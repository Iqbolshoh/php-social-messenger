<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $response['status'] = 'error';
    $response['message'] = 'Unauthorized access. Please log in.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

include '../config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => ''
];

if (isset($_POST['user_id'], $_POST['action'])) {
    $user_id = (int) $_POST['user_id'];
    $action = $_POST['action'];
    $current_user_id = $_SESSION['user_id'];

    $user_exists = $query->select('users', 'id', 'id = ?', [$user_id], 'i');
    if (empty($user_exists)) {
        $response['status'] = 'error';
        $response['message'] = 'User not found.';
        echo json_encode($response);
        exit;
    }

    $existing_block = $query->select('block_users', '*', 'blocked_by = ? AND blocked_user = ?', [$current_user_id, $user_id], 'ii');

    if ($action == 'block' && !$existing_block) {
        $result = $query->insert('block_users', ['blocked_by' => $current_user_id, 'blocked_user' => $user_id]);

        if ($result > 0) {
            $response['status'] = 'success';
            $response['message'] = 'User has been blocked successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to block the user. Please try again later.';
        }
    } elseif ($action == 'unblock' && $existing_block) {
        $result = $query->delete('block_users', 'blocked_by = ? AND blocked_user = ?', [$current_user_id, $user_id], 'ii');

        if ($result > 0) {
            $response['status'] = 'success';
            $response['message'] = 'User has been unblocked successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to unblock the user. Please try again later.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid action or the user is already in the requested state.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request. Both user_id and action parameters are required.';
}

header('Content-Type: application/json');
echo json_encode($response);
