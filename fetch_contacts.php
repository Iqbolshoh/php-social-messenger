<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];

$response = [
    'status' => '',
    'message' => ''
];

$allUsers = $query->executeQuery('
    SELECT 
        u.id AS user_id, 
        u.full_name, 
        u.email, 
        u.profile_picture, 
        m.receiver_id, 
        MAX(m.created_at) AS last_message_time
    FROM 
        users u
    LEFT JOIN 
        messages m ON m.receiver_id = u.id AND m.sender_id = ?
    WHERE 
        u.id != ?
    GROUP BY 
        u.id
    ORDER BY 
        last_message_time DESC;
', [$sender_id, $sender_id], 'ii')->get_result();

if ($allUsers) {

    $response['status'] = 'succes';
    $response['message'] = 'Message sent successfully';

    foreach ($allUsers as $user) {
        $response[] = $user;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
