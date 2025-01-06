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
    header("Location: ../");
    exit;
}

if (isset($_COOKIE['username']) && isset($_COOKIE['session_token'])) {

    if (session_id() !== $_COOKIE['session_token']) {
        session_write_close();
        session_id($_COOKIE['session_token']);
        session_start();
    }

    $result = $query->select('users', '*', "username = ?", [$_COOKIE['username']], 's');

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_picture'] = $user['profile_picture'];

        $response['status'] = 'success';
        $response['message'] = 'Login successful';
        $response['data'] = [
            'loggedin' => true,
            'user_id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'username' => $username,
            'profile_picture' => $user['profile_picture']
        ];

        header("Location: ../");
        exit;
    }
}

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

    header('Content-Type: application/json');
    echo json_encode($response);
}
