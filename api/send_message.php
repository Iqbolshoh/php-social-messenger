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
    'message' => '',
    'data' => []
];

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

header('Content-Type: application/json');
echo json_encode($response);
