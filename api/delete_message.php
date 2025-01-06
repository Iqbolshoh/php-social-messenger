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

echo json_encode($response);
