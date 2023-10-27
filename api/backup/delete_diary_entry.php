<?php
// delete_diary_entry.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'));

    // Check if 'id' and 'requestingUserID' parameters are provided in the JSON data
    if (isset($data->id) && isset($data->requestingUserID)) {
        $id = $data->id;
        $requestingUserID = $data->requestingUserID;

        // Prepare a SELECT statement to retrieve the userID associated with the diary entry
        $selectStmt = $conn->prepare("SELECT userID FROM diary_entries WHERE id = ?");
        $selectStmt->bind_param("i", $id);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $selectStmt->close();

        if ($result->num_rows == 1) {
            $entry = $result->fetch_assoc();

            // Check if the requesting user is the owner of the diary entry
            if ($entry['userID'] == $requestingUserID) {
                // If the requesting user is the owner, proceed with the deletion
                $deleteStmt = $conn->prepare("DELETE FROM diary_entries WHERE id = ?");
                $deleteStmt->bind_param("i", $id);

                if ($deleteStmt->execute() && $deleteStmt->affected_rows > 0) {
                    echo json_encode(array("success" => true, "message" => "Diary entry deleted successfully."));
                } else {
                    echo json_encode(array("success" => false, "message" => "Error deleting diary entry: " . $deleteStmt->error));
                }

                $deleteStmt->close();
            } else {
                // If the requesting user is not the owner, deny the deletion
                echo json_encode(array("success" => false, "message" => "Access denied. You are not the owner of this diary entry."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Diary entry not found or already deleted."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Missing 'id' and/or 'requestingUserID' parameters in the request."));
    }
}
?>
