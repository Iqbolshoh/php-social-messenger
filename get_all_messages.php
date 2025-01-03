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

$private_messages = $query->select(
    'private_messages',
    '*',
    "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) ORDER BY created_at",
    [$sender_id, $receiver_id, $receiver_id, $sender_id],
    "iiii"
);

header('Content-Type: application/json');

if (empty($private_messages)) {
    echo json_encode(['No message available']);
    exit;
}

echo json_encode($private_messages);
