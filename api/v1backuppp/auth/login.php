<?php
// login.php
include '../includes/cors_headers.php'; // Include the CORS headers
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $username = $data->username;
    $password = $data->password;

    // Check if the username exists
    $stmt = $conn->prepare("SELECT userID, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 1) {
        // Username exists, check the password
        $user = $result->fetch_assoc();
        $storedPassword = $user['password']; // Get hashed password from the database

        if (password_verify($password, $storedPassword)) {
            // Password is correct
            $response = ["success" => true, "message" => "Login successful", "userId" => $user['userID']];
            echo json_encode($response);
        } else {
            $response = ["success" => false, "message" => "Incorrect password. Please try again."];
            echo json_encode($response);
        }
    } else {
        $response = ["success" => false, "message" => "Username not found. Please check your username."];
        echo json_encode($response);
    }
}
?>
