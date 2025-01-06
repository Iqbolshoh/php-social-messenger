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
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['profile_picture'] = $user['profile_picture'];

                setcookie('username', $username, time() + (86400 * 30), "/", "", true, true);
                setcookie('session_token', session_id(), time() + (86400 * 30), "/", "", true, true);

                $response['status'] = 'success';
                $response['message'] = 'Login successful';
                $response['data'] = [
                    'loggedin' => true,
                    'user_id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'profile_picture' => $user['profile_picture']
                ];
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
