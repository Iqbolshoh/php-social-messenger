<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($message_id = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT)) {
    $updated = $query->update(
        'private_messages',
        ['status' => 'read'],
        'id = ?',
        [$message_id],
        'i'
    );

    $response = $updated > 0
        ? ['status' => 'success', 'message' => 'Message marked as read']
        : ['status' => 'error', 'message' => 'Failed to update message status'];
}

header('Content-Type: application/json');
echo json_encode($response);
