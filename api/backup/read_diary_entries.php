<?php
// read_diary_entries.php
include 'cors_headers.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the 'userID' parameter is set in the URL
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];

        $stmt = $conn->prepare("SELECT id, title, content, category, entry_time FROM diary_entries WHERE userID = ?");
        $stmt->bind_param("i", $userID);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();

            $entries = array();
            while ($row = $result->fetch_assoc()) {
                $entries[] = $row;
            }

            // Check if any entries were found
            if (!empty($entries)) {
                echo json_encode(array("success" => true, "entries" => $entries));
            } else {
                echo json_encode(array("success" => false, "message" => "No diary entries found for the user."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Database query failed."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Missing 'userID' parameter."));
    }
}
?>
