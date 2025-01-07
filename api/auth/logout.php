<?php
session_start();

session_unset();
session_destroy();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$cookies = ['username', 'session_token'];
foreach ($cookies as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        setcookie($cookie, '', time() - 3600, '/');
    }
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$response = [
    'status' => 'success',
    'message' => 'User successfully logged out',
    'redirect' => 'login/'
];

header('Content-Type: application/json');
echo json_encode($response);

exit;
