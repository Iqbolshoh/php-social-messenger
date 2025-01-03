<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];

$response = [
    'status' => '',
    'message' => ''
];

if (isset($receiver_id) && isset($_POST['action_type'])) {
    $action_type = $_POST['action_type'];

    $data = [
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'action_type' => $action_type
    ];

    $result = $query->insert('action', $data);

    if (is_numeric($result)) {

        $response['status'] = 'success';
        $response['message'] = 'action added successfully';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
