<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];

$response = [
    'status' => '',
    'message' => ''
];

if (isset($_GET['receiver_id'])) {
    $receiver_id = $_GET['receiver_id'];

    $result = $query->delete(
        'action',
        'sender_id = ? AND receiver_id = ?',
        [$sender_id, $receiver_id],
        'ii'
    );

    if ($result > 0) {
        $response['status'] = 'success';
        $response['message'] = 'action successfully deleted';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
