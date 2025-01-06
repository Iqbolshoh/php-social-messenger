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

    $message_id = (int) $_POST['message_id'];

    $message = $query->select('messages', '*', 'id = ?', [$message_id], 'i');

    if (!empty($message)) {
        $sender_id = $_SESSION['user_id'];
        $message_id = $_POST['message_id'];

        $delete_result =  $query->delete(
            'messages',
            'id = ?',
            [$message_id],
            'i'
        );

        if ($delete_result > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Message deleted successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to delete the message. Please try again later.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Message not found.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Message ID is required.';
}

header('Content-Type: application/json');
echo json_encode($response);
