<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

header('Content-Type: application/json');
$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $response['status'] = 'error';
    $response['message'] = 'User is not logged in';
    $response['data'] = [
        'loggedin' => false
    ];
    echo json_encode($response);
    exit;
}

include '../config.php';
$query = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content']) && !empty($_POST['content']) && isset($_POST['receiver_id'])) {

    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message_text = trim($_POST['content']);

    $data = [
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'content' => $message_text,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $insertResult = $query->insert('messages', $data);

    if ($insertResult) {
        $new_message = [
            'id' => $insertResult,
            'content' => $message_text,
            'created_at' => $data['created_at']
        ];

        $response['status'] = 'success';
        $response['message'] = 'Message sent successfully';
        $response['data'] = $new_message;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to send the message. Please try again later.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Message content and receiver ID are required.';
}

echo json_encode($response);
