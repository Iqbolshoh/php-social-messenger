<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}

include '../config.php';
$query = new Database();

$response = ['exists' => false];

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $email_check = $query->select('users', 'email', 'email = ?', [$email], 's');
    if ($email_check) {
        $response['exists'] = true;
    }
}

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $username_check = $query->select('users', 'username', 'username = ?', [$username], 's');
    if ($username_check) {
        $response['exists'] = true;
    }
}

echo json_encode($response);
exit;
