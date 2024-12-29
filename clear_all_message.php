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

if (isset($_POST['clear']) && $_POST['clear'] == true) {
    $query->delete(
        'private_messages',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) ORDER BY created_at",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );
}

echo 'Delete all message successfully';

