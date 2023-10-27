<?php
// Database configuration
$server = "localhost"; // Change to your database server host
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$database = "diary_api"; // Change to your database name

// Create a database connection
$conn = new mysqli($server, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8 (optional, if needed)
$conn->set_charset("utf8");

// Optionally, you can define other configurations or functions related to your database here.

?>
