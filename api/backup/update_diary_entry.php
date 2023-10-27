<?php
// update_diary_entry.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'));

    $entryID = $data->id;
    $title = $data->title;
    $content = $data->content;
    $category = $data->category;

    $stmt = $conn->prepare("UPDATE diary_entries SET title = ?, content = ?, category = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $content, $category, $entryID);

    if ($stmt->execute()) {
        echo "Diary entry updated successfully.";
    } else {
        echo "Error updating diary entry: " . $stmt->error;
    }

    $stmt->close();
}
