<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => ''
];

if (isset($_POST['message_id']) && isset($_POST['new_message'])) {
    $message_id = $_POST['message_id'];
    $new_message = $_POST['new_message'];
    $user_id = $_SESSION['user_id'];

    $message = $query->select(
        'messages',
        '*',
        'id = ? AND sender_id = ?',
        [$message_id, $user_id],
        'ii'
    );

    if ($message) {

        $data = ['content' => $new_message];
        $result = $query->update(
            'messages',
            $data,
            'id = ?',
            [$message_id],
            'i'
        );

        if ($result > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Message updated successfully';
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
