<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/");
    exit;
}

include '../config.php';
$query = new Database();

$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

$sender_id = $_SESSION['user_id'];
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchTermLike = "%" . $searchTerm . "%";

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
            messages m ON (m.receiver_id = u.id AND m.sender_id = ?)
            OR (m.receiver_id = ? AND m.sender_id = u.id)
        WHERE 
            u.id != ? AND 
            (u.full_name LIKE ? OR u.username LIKE ?) 
        GROUP BY 
            u.id 
        ORDER BY 
            last_message_time DESC, 
            u.id ASC';

$allUsers = $query->executeQuery($sql, [$sender_id, $sender_id, $sender_id, $searchTermLike, $searchTermLike], 'iiiis')->get_result();

if ($allUsers && $allUsers->num_rows > 0) {
    $result = [];

    while ($user = $allUsers->fetch_assoc()) {
        $unreadMessagesQuery = '
            SELECT COUNT(*) AS unread_messages 
            FROM messages 
            WHERE receiver_id = ? AND sender_id = ? AND status = "unread"';

        $unreadMessages = $query->executeQuery($unreadMessagesQuery, [$sender_id, $user['user_id']], 'ii')->get_result()->fetch_assoc();
        $user['unread_messages'] = $unreadMessages['unread_messages'];

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
