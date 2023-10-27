<?php
// fetch_diary_entry.php
include '../includes/cors_headers.php';
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $entryId = $_GET['id'];

        $stmt = $conn->prepare("SELECT title, content, category FROM diary_entries WHERE id = ?");
        $stmt->bind_param("i", $entryId);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();

            if ($row = $result->fetch_assoc()) {
                echo json_encode(array("success" => true, "entry" => $row));
            } else {
                echo json_encode(array("success" => false, "message" => "Diary entry not found."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Database query failed."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Missing 'id' parameter."));
    }
}
?>
