<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = isset($_GET['id']) ? intval($_GET['id']) : null;


if ($sender_id == $receiver_id || $receiver_id == null) {
    header("Location: ./");
    exit;
}

if (empty($query->select('users', '*', 'id = ?', [$receiver_id], 'i'))) {
    header("Location: ./");
    exit;
}

$private_messages = $query->select(
    'private_messages',
    '*',
    "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ? AND status = ?)) AND status = ? ORDER BY created_at",
    [$sender_id, $receiver_id, $receiver_id, $sender_id, 'unread', 'unread'],
    "iiiiss"
);

$message_count = count($private_messages);

header('Content-Type: application/json');
echo json_encode([
    "status" => 'success',
    "message_count" => $message_count,
    "private_messages" => $private_messages
]);
