<?php
// login.php
include 'cors_headers.php'; // Include the CORS headers
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $username = $data->username;
    $password = $data->password;

    // Check if the username exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 1) {
        // Username exists, check the password
        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];

        if ($password === $storedPassword) {
            echo "Login successful.";
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Username not found. Please check your username.";
    }
}
?>
