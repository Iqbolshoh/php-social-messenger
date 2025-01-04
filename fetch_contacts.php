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
    'message' => '',
    'data' => ''
];

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = 'SELECT 
        u.id AS user_id, 
        u.full_name, 
        u.username, 
        u.profile_picture, 
        m.receiver_id, 
        MAX(m.created_at) AS last_message_time
    FROM 
        users u 
    LEFT JOIN 
        messages m ON m.receiver_id = u.id AND m.sender_id = ? 
    WHERE 
        u.id != ? AND 
        (u.full_name LIKE ? OR u.username LIKE ?) 
    GROUP BY 
        u.id 
    ORDER BY 
        last_message_time DESC, 
        u.id ASC;';

$searchTermLike = "%" . $searchTerm . "%";
$allUsers = $query->executeQuery($sql, [$sender_id, $sender_id, $searchTermLike, $searchTermLike], 'iiis')->get_result();

if ($allUsers) {
    $result = [];
    foreach ($allUsers as $user) {
        $result[] = $user;
    }

    $response['status'] = 'success';
    $response['message'] = 'Contacts retrieved successfully';
    $response['data'] = $result;
} else {
    $response['status'] = 'error';
    $response['message'] = 'No contacts found';
}

header('Content-Type: application/json');
echo json_encode($response);
