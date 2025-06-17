<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');
session_start();

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
        'user_id' => $_SESSION['user_id'],
        'full_name' => $_SESSION['full_name'],
        'email' => $_SESSION['email'],
        'username' => $_SESSION['username'],
        'profile_picture' => $_SESSION['profile_picture']
    ];
} else {
    $response['status'] = 'error';
    $response['message'] = 'User is not logged in';
    $response['data'] = [
        'loggedin' => false
    ];
}

echo json_encode($response);
