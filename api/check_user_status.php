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
    'message' => ''
];

if (isset($_GET['receiver_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = (int) $_GET['receiver_id'];

    $blocked = $query->select('block_users', '*', 'blocked_by = ? AND blocked_user = ?', [$receiver_id, $sender_id], 'ii');

    if (!empty($blocked)) {
        $response['status'] = 'blocked';
        $response['message'] = 'You are blocked by this user.';
    } else {
        $response['status'] = 'unblocked';
        $response['message'] = 'You are not blocked by this user.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Receiver ID is required. Please provide a valid receiver ID.';
}

echo json_encode($response);
