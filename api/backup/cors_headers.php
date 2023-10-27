<?php
// cors_headers.php
header("Access-Control-Allow-Origin: *"); // Replace with the actual origin of your React app
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
