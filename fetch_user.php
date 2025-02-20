<?php
// filepath: fetch_user.php
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin (DO NOT USE IN PRODUCTION)
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allowed methods
header('Access-Control-Allow-Headers: Content-Type'); // Allowed headers

require_once 'config/database.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Sanitize input

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM tbl_users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'User not found']);
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid request']);
}

mysqli_close($conn);
?>