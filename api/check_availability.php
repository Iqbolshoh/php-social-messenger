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

$response = ['exists' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $result = $query->select('users', 'email', 'email = ?', [$email], 's');
        if (!empty($result)) {
            $response['exists'] = true;
        }
    }
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $result = $query->select('users', 'username', 'username = ?', [$username], 's');
        if (!empty($result)) {
            $response['exists'] = true;
        }
    }
}

echo json_encode($response);
?>
