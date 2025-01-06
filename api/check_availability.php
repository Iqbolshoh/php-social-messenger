<?php
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
