<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];

$result = $query->select('users', '*', 'id = ?', [$sender_id], 'i');

$response = [
    'status' => 'error',
    'message' => 'User not found',
    'data' => []
];

if (isset($result[0])) {
    $user = $result[0];
    $response = [
        'status' => 'success',
        'message' => 'User data fetched successfully',
        'data' => $user
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
