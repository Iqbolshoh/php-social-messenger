<?php

session_start();

include '../config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => '',
];

if (isset($_COOKIE['username']) && isset($_COOKIE['session_token'])) {

    if (session_id() !== $_COOKIE['session_token']) {
        session_write_close();
        session_id($_COOKIE['session_token']);
        session_start();
    }

    $result = $query->select('users', 'id', "username = ?", [$_COOKIE['username']], 's');

    if (!empty($result)) {
        $user = $result[0];

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['user_id'] = $user['id'];

        header("Location: ../");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = strtolower(trim($_POST['username']));
        $password = trim($_POST['password']);

        $result = $query->select('users', '*', "username = ?", [$username], 's');

        if (!empty($result)) {
            $user = $result[0];

            if ($user['password'] == $query->hashPassword($password)) {

                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
                setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

                $response['status'] = 'success';
                $response['message'] = 'Login successful';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Incorrect username or password';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No user found with that username';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Please provide both username and password';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

header('Content-Type: application/json');
echo json_encode($response);
