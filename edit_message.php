<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

if (isset($_POST['message_id']) && isset($_POST['new_message'])) {
    $message_id = $_POST['message_id'];
    $new_message = $_POST['new_message'];
    $user_id = $_SESSION['user_id'];

    $message = $query->select('private_messages', '*', 'id = ? AND sender_id = ?', [$message_id, $user_id], 'ii');

    if ($message) {
        $data = ['content' => $new_message];
        $result = $query->update('private_messages', $data, 'id = ?', [$message_id], 'i');

        if ($result > 0) {
            echo 'Message updated successfully';
        } else {
            echo 'Error: Unable to update the message';
        }
    } else {
        echo 'Error: You cannot edit this message';
    }
}
