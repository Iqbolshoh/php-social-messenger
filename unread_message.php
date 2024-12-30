<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$receiver_id || $sender_id === $receiver_id) {
    header("Location: ./");
    exit;
}

$messages = $query->select(
    'private_messages',
    '*',
    '((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) AND status = ? ORDER BY created_at',
    [$sender_id, $receiver_id, $receiver_id, $sender_id, 'unread'],
    'iiiis'
);

$response = [
    'status' => 'success',
    'message_count' => count($messages),
    'private_messages' => $messages,
];

header('Content-Type: application/json');
echo json_encode($response);
