<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];

    $query = new Database();
    $query->delete('private_messages', 'id = ?', [$message_id], 'i');

    echo 'Message deleted successfully';
}
