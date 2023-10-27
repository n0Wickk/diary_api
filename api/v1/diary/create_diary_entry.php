<?php
// create_diary_entry.php
include '../includes/cors_headers.php';
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $userID = $data->userId;
    $title = $data->title;
    $content = $data->content;
    $category = $data->category;

    $stmt = $conn->prepare("INSERT INTO diary_entries (userID, title, content, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userID, $title, $content, $category);

    if ($stmt->execute()) {
        echo "Diary entry created successfully.";
    } else {
        echo "Error creating diary entry: " . $stmt->error;
    }

    $stmt->close();
}
