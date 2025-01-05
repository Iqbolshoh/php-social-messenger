<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['user_id']; 

$blocked = $query->select('block_users', '*', 'blocked_by = ? AND blocked_user = ?', [$receiver_id, $sender_id], 'ii');

$response = [];
if (!empty($blocked)) {
    $response['status'] = 'blocked';
} else {
    $response['status'] = 'unblocked';
}
$response['status'] = 'unblocked';


echo json_encode($response);
