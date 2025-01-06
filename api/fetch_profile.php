<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

header('Content-Type: application/json');
$response = [
    'status' => '',
    'message' => '',
    'data' => []
];

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $response['status'] = 'error';
    $response['message'] = 'User is not logged in';
    $response['data'] = [
        'loggedin' => false
    ];
    echo json_encode($response);
    exit;
}

include '../config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];

$result = $query->select('users', '*', 'id = ?', [$sender_id], 'i');
$user = $result[0] ?? null;

if ($user) {
    $response = [
        'status' => 'success',
        'message' => 'User data fetched successfully',
        'data' => $user
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {

    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    $profile_picture = $user['profile_picture'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            $response['message'] = 'Invalid file type. Only JPG, JPEG, PNG, GIF files are allowed.';
            echo json_encode($response);
            exit;
        }

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadDir = '../src/images/profile-picture/';
        $destPath = $uploadDir . $newFileName;

        if ($profile_picture && $profile_picture !== 'default.png') {
            $oldFilePath = $uploadDir . $profile_picture;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profile_picture = $newFileName;
        } else {
            $response['message'] = 'Error uploading the file. Please try again.';
            echo json_encode($response);
            exit;
        }
    }

    $updateData = ['full_name' => $full_name, 'profile_picture' => $profile_picture];

    if (!empty($password)) {
        $updateData['password'] = $query->hashPassword($password);
    }

    $updateResult = $query->update('users', $updateData, 'id = ?', [$sender_id], 'i');

    if ($updateResult > 0) {
        $_SESSION['full_name'] = $full_name;
        $_SESSION['profile_picture'] = $profile_picture;

        $response = [
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $updateData
        ];
    } else {
        $response['message'] = 'Failed to update profile. Please try again.';
    }
}

echo json_encode($response);
