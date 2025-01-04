<?php

session_start();

// Foydalanuvchi tizimga kirganligini tekshirish
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$response = ['status' => '', 'message' => ''];

if (isset($_POST['user_id'], $_POST['action'])) {
    
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];
    $current_user_id = $_SESSION['user_id'];

    $table = 'block_users';
    $existing_block = $query->select($table, '*', 'blocked_by = ? AND blocked_user = ?', [$current_user_id, $user_id], 'ii');

    if ($action == 'block' && !$existing_block) {
        $result = $query->insert($table, ['blocked_by' => $current_user_id, 'blocked_user' => $user_id]);

        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'User has been blocked successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to block the user. Please try again later.';
        }
    } elseif ($action == 'unblock' && $existing_block) {
        $result = $query->delete($table, 'blocked_by = ? AND blocked_user = ?', [$current_user_id, $user_id], 'ii');

        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'User has been unblocked successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to unblock the user. Please try again later.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid action or user is not blocked.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Required parameters are missing.';
}

header('Content-Type: application/json');
echo json_encode($response);
