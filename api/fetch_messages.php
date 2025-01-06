<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/");
    exit;
}

include '../config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

if (isset($_POST['id'])) {

    $sender_id = $_SESSION['user_id'];
    $receiver_id = (int) $_POST['id'];

    $updateData = [
        'status' => 'read'
    ];

    $condition = "sender_id = ? AND receiver_id = ? AND status = 'unread'";

    $updateResult = $query->update('messages', $updateData, $condition, [$sender_id, $receiver_id], 'ii');

    if ($updateResult > 0) {
        $response['status'] = 'success';
        $response['message'] = 'Messages marked as read successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to mark messages as read';
    }

    $messages = $query->select(
        'messages',
        '*',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) 
         ORDER BY created_at",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );

    $response['data'] = $messages;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Receiver ID is required';
}

header('Content-Type: application/json');
echo json_encode($response);
