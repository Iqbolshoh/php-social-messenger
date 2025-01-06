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

if (isset($_POST['message_id'], $_POST['new_message'])) {

    $sender_id = $_SESSION['user_id'];
    $message_id = (int) $_POST['message_id'];
    $new_message = trim($_POST['new_message']);

    if (empty($new_message)) {
        $response['message'] = 'Message content cannot be empty.';
    } else {

        $message = $query->select(
            'messages',
            '*',
            'id = ? AND sender_id = ?',
            [$message_id, $sender_id],
            'ii'
        );

        if ($message) {

            $data = ['content' => $new_message];
            $update_result = $query->update(
                'messages',
                $data,
                'id = ?',
                [$message_id],
                'i'
            );

            if ($update_result > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Message updated successfully';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to update message. Please try again later.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Message not found or you do not have permission to edit this message.';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request or missing parameters.';
}

header('Content-Type: application/json');
echo json_encode($response);
