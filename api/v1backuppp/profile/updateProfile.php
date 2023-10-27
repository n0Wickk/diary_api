<?php
// updateProfile.php
include '../includes/cors_headers.php'; // Include the CORS headers
include '../includes/config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    echo "hello";

    $userId = $data->userId; // Make sure to send the user's ID
    $newUsername = $data->newUsername;
    $newBio = $data->newBio;
    $newGender = $data->newGender;
    $newYouTubeURL = $data->newYouTubeURL;

    // Check if the user exists and update the profile
    $stmt = $conn->prepare("UPDATE users SET username = ?, bio = ?, gender = ?, youtube_url = ? WHERE userID = ?");
    $stmt->bind_param("ssssi", $newUsername, $newBio, $newGender, $newYouTubeURL, $userId);

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}
?>
