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

if (isset($_POST['id'])) {

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['id'];

    $data = ['status' => 'read'];
    $update_result = $query->update(
        'messages',
        $data,
        'sender_id = ? AND receiver_id = ? AND status = "unread"',
        [$receiver_id, $sender_id],
        'ii'
    );

    $response['status'] = 'success';
    $response['message'] = 'Messages fetched successfully';
    $messages = $query->select(
        'messages',
        '*',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) 
         ORDER BY created_at",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );

    if (!empty($messages)) {
        $response['data'] = $messages;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No messages found';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Receiver ID is required';
}

echo json_encode($response);