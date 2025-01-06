<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

header('Content-Type: application/json');
$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $response['status'] = 'error';
    $response['message'] = 'User is not logged in';
    $response['data'] = [
        'loggedin' => false
    ];
    echo json_encode($response);
    exit;
}

include '../config.php';
$query = new Database();

if (isset($_POST['clear']) && $_POST['clear'] == true && isset($_POST['receiver_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = (int) $_POST['receiver_id'];

    $deleted = $query->delete(
        'messages',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );

    if ($deleted > 0) {
        $response['status'] = 'success';
        $response['message'] = 'All messages successfully deleted.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No messages found to delete or an error occurred.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request. Please provide necessary parameters.';
}

echo json_encode($response);
