<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => '',
    'data' => ''
];

if (isset($_POST['id'])) {

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['id'];

    $response['status'] = 'success';
    $response['message'] = 'Fetch Message successfully';

    $response['data'] = $query->select(
        'messages',
        '*',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) ORDER BY created_at",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );
}

header('Content-Type: application/json');
echo json_encode($response);
