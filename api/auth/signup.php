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
    echo json_encode($response);
    exit;
}

include '../../config.php';
$query = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $query->validate($_POST['full_name']);
    $email = $query->validate($_POST['email']);
    $username = $query->validate($_POST['username']);
    $password = $query->hashPassword($_POST['password']);

    $data = [
        'full_name' => $full_name,
        'email' => $email,
        'username' => $username,
        'password' => $password
    ];

    $result = $query->insert('users', $data);

    if (!empty($result)) {
        $user_id = $query->select('users', 'id', 'username = ?', [$username], 's')[0]['id'];

        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['profile_picture'] = 'default.png';

        setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
        setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

        $response['status'] = 'success';
        $response['message'] = 'Registration successful';
        $response['data'] = [
            'loggedin' => true,
            'user_id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'username' => $username,
            'profile_picture' => 'default.png'
        ];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Registration failed. Please try again later.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
