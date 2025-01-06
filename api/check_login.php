<?php
session_start();
include '../config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $response['status'] = 'success';
    $response['message'] = 'User is logged in';
    $response['data'] = [
        'loggedin' => true,
        'username' => $_SESSION['username'],
        'user_id' => $_SESSION['user_id']
    ];
} else {
    $response['status'] = 'error';
    $response['message'] = 'User is not logged in';
    $response['data'] = [
        'loggedin' => false
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
