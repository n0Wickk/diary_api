<?php
// get_user_info.php
include '../includes/cors_headers.php'; // Include the CORS headers
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Query to fetch all user information based on userId
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $response = [
                "success" => true,
                "userData" => [
                    "id" => $user['id'],
                    "username" => $user['username'],
                    "bio" => $user['bio'],
                    "gender" => $user['gender'],
                    "url" => $user['youtube_url']
                    // Add other user data fields here as needed
                ],
            ];
            echo json_encode($response);
        } else {
            $response = ["success" => false, "message" => "User not found."];
            echo json_encode($response);
        }
    } else {
        $response = ["success" => false, "message" => "Missing 'id' parameter."];
        echo json_encode($response);
    }
}
?>
