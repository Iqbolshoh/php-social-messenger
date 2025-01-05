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

if (isset($_POST['message_id'])) {
    
    $message_id = $_POST['message_id'];
    $message =  $query->delete(
        'messages',
        'id = ?',
        [$message_id],
        'i'
    );

    if ($message > 0) {
        $response['status'] = 'success';
        $response['message'] = 'Message deleted successfully';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
