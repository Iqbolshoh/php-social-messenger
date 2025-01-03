<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = isset($_POST['id']) ? intval($_POST['id']) : null;

$response = [
    'status' => '',
    'message' => ''
];

if ($receiver_id) {
    $response = $query->select(
        'action',
        '*',
        "sender_id = ? AND receiver_id = ?",
        [$sender_id, $receiver_id],
        "ii"
    );
}

header('Content-Type: application/json');
echo json_encode($response);
