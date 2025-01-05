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

if (isset($_POST['clear']) && $_POST['clear'] == true) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    
    $deleted = $query->delete(
        'messages',
        "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) ORDER BY created_at",
        [$sender_id, $receiver_id, $receiver_id, $sender_id],
        "iiii"
    );

    if ($deleted) {
        $response['status'] = 'success';
        $response['message'] = 'Delete all messages successfully';
    }
} 

header('Content-Type: application/json');
echo json_encode($response);
