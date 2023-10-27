<?php
// diary_entries.php
include 'config.php'; // Include your database configuration

// Function to create the diary_entries table if it doesn't exist
function createDiaryEntriesTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS diary_entries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        userID INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        category VARCHAR(50),
        entry_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === true) {
        echo "Diary Entries table created successfully.";
    } else {
        echo "Error creating Diary Entries table: " . $conn->error;
    }
}

// Create the diary_entries table
createDiaryEntriesTable($conn);

// Rest of your diary entry API code goes here
