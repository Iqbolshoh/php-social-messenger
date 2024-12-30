<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];

$response = [
    'status' => '',
    'message' => ''
];

if (isset($_POST['clear']) && $_POST['clear'] == true) {
    $deleted = $query->delete(
        'private_messages',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) ORDER BY created_at",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );

    if ($deleted) {
        $response['status'] = 'success';
        $response['message'] = 'Delete all messages successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete messages';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response);
