<?php

session_start();

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

    $existing_block = $query->select('block_users', '*', 'blocked_by = ? AND blocked_user = ?', [$current_user_id, $user_id], 'ii');

    if ($action == 'block' && !$existing_block) {
        // Block user
        $result = $query->insert('block_users', ['blocked_by' => $current_user_id, 'blocked_user' => $user_id]);

        if ($result > 0) {
            $response['status'] = 'success';
            $response['message'] = 'User has been blocked successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to block the user.';
        }
    } elseif ($action == 'unblock' && $existing_block) {
        // Unblock user
        $result = $query->delete('block_users', 'blocked_by = ? AND blocked_user = ?', [$current_user_id, $user_id], 'ii');

        if ($result > 0) {
            $response['status'] = 'success';
            $response['message'] = 'User has been unblocked successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to unblock the user.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid action or user is already in the requested state.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
