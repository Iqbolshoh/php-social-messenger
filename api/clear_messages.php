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

if (isset($_POST['clear']) && $_POST['clear'] == true && isset($_POST['receiver_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = (int) $_POST['receiver_id'];

    $deleted = $query->delete(
        'messages',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );

    if ($deleted > 0) {
        $response['status'] = 'success';
        $response['message'] = 'All messages successfully deleted.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No messages found to delete or an error occurred.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request. Please provide necessary parameters.';
}

header('Content-Type: application/json');
echo json_encode($response);
