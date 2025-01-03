<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$user_id = $_SESSION['user_id'];
$allUsers = $query->select('users', '*', 'id <> ?', [$user_id], 'i');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Chat</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="./src/css/style.css">
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">

            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header">
                        <div class="input-group">
                            <input type="text" placeholder="Search..." name="" class="form-control search">
                            <div class="input-group-prepend">
                                <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body contacts_body">
                        <ui class="contacts">

                            <?php foreach ($allUsers as $user) : ?>

                                <li onclick="window.location.href='chat.php?id=<?= $user['id'] ?>'">
                                    <div class="d-flex bd-highlight">
                                        <div class="img_cont">
                                            <img src="./src/images/profile-picture/<?= $user['profile_picture'] ?>"
                                                class="rounded-circle user_img">
                                        </div>
                                        <div class="user_info">
                                            <span><?= $user['full_name'] ?></span>
                                            <p><?= $user['email'] ?></p>
                                        </div>
                                    </div>
                                </li>

                            <?php endforeach ?>
                        </ui>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>