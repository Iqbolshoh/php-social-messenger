<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/");
    exit;
}

include '../config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$result = $query->select('users', '*', 'id = ?', [$sender_id], 'i');

$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

if (isset($result[0])) {
    $user = $result[0];
    $response = [
        'status' => 'success',
        'message' => 'User data fetched successfully',
        'data' => $user
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $profile_picture = $user['profile_picture'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../src/images/profile-picture/';
        $dest_path = $uploadFileDir . $newFileName;

        if ($profile_picture && $profile_picture !== 'default.png') {
            $oldFilePath = $uploadFileDir . $profile_picture;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_picture = $newFileName;
        }
    }

    $updateData = [
        'full_name' => $full_name,
        'profile_picture' => $profile_picture
    ];

    if (!empty($password)) {
        $updateData['password'] = $query->hashPassword($password);
    }

    $query->update('users', $updateData, 'id = ?', [$sender_id], 'i');

    $_SESSION['full_name'] = $full_name;
    $_SESSION['profile_picture'] = $profile_picture;

    $response = [
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'data' => $updateData
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
