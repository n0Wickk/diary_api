<?php
// registration.php
include '../includes/cors_headers.php'; // Include the CORS headers
include '../includes/config.php';

function isUsernameExists($conn, $username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $newUsername = $data->username;
    $password = password_hash($data->password, PASSWORD_DEFAULT); // Hash the password
    $gender = $data->gender;
    $bio = $data->bio;
    $youtube_url = $data->youtube_url;

    if (isUsernameExists($conn, $newUsername)) {
        echo "Username already exists. Please choose a different username.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, bio, gender, youtube_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $newUsername, $password, $bio, $gender, $youtube_url);

        if ($stmt->execute()) {
            echo "User registered successfully.";
        } else {
            echo "Error registering the user: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
