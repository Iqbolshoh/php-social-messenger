<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$receiver_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($sender_id == $receiver_id || $receiver_id == null) {
    header("Location: ./");
    exit;
}

if (empty($query->select('users', '*', 'id = ?', [$receiver_id], 'i'))) {
    header("Location: ./");
    exit;
}

$sender_user = $query->select('users', '*', 'id = ?', [$sender_id], 'i')[0];
$receiver_user = $query->select('users', '*', 'id = ?', [$receiver_id], 'i')[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Chat</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="./src/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">

            <div class="col-md-8 col-xl-6 chat">

                <div class="card">
                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="./src/images/profile-picture/<?= $receiver_user['profile_picture'] ?>"
                                    class="rounded-circle user_img">
                            </div>
                            <div class="user_info">
                                <span><?= $receiver_user['full_name'] ?></span>
                                <p><b style="font-weight:normal"><?= 777 ?> </b>Messages</p>
                            </div>
                        </div>
                        <span id="action_menu_btn_user" style="padding: 5px;">
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="action_menu_user" style="display: none;">
                            <ul>
                                <li><i class="fas fa-user-circle"></i> View profile</li>
                                <li style="color: orange" id="clearBtn"><i class="fas fa-times-circle"></i> Clear</li>
                                <li style="color: red"><i class="fas fa-ban"></i> Block</li>
                            </ul>
                        </div>
                    </div>

                    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="display:flex; justify-content:center;">
                            <div class="modal-content" style="background: #7F7FD5; background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5); background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5); border: none; border-radius: 11px; max-width:calc(100% - 20px); top: 15px">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="profileModalLabel"><?= $receiver_user['full_name'] ?>'s Profile</h5>
                                    <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="./src/images/profile-picture/<?= $receiver_user['profile_picture'] ?>" class="rounded-circle mb-4" width="100" height="100">
                                        <h5><?= $receiver_user['full_name'] ?></h5>
                                        <p><?= $receiver_user['email'] ?></p>
                                        <p>@<?= $receiver_user['username'] ?></p>
                                        <p>Joined on: <?= date("F j, Y", strtotime($receiver_user['created_at'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body msg_card_body" id="messages-container"></div>

                    <div class="card-footer">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                            </div>
                            <textarea class="form-control type_msg" placeholder="Type your message..."></textarea>
                            <div class="input-group-append">
                                <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const msgCardBody = document.querySelector(".msg_card_body");
            if (msgCardBody) {
                msgCardBody.scrollTop = msgCardBody.scrollHeight;
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
</body>

</html>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const receiverId = <?= $receiver_id ?>;
        const senderId = <?= $sender_id ?>;
        const senderProfilePicture = "<?= $sender_user['profile_picture'] ?>";
        const receiverProfilePicture = "<?= $receiver_user['profile_picture'] ?>";

        const messagesContainer = document.getElementById('messages-container');

        function getMessages() {
            fetch(`get_all_messages.php?id=${receiverId}`)
                .then(response => response.json())
                .then(privateMessages => {
                    if (privateMessages && privateMessages.length > 0) {
                        messagesContainer.innerHTML = '';
                        privateMessages.forEach(privateMessage => {
                            const isSender = privateMessage.sender_id === senderId;

                            if (isSender) {
                                const senderMessage = `
                                <div class="d-flex justify-content-end mb-4 message-container" style="margin-left:15px" data-message-id="${privateMessage.id}">
                                    <div style="display: flex; justify-content: center; align-items:center">
                                        <div class="relative-container" id="sender">
                                            <span class="action_menu_btn" style="cursor: pointer; padding: 5px"><i class="fas fa-ellipsis-v" style="color: #78e08f;"></i></span>
                                            <div class="action_menu">
                                                <ul>
                                                    <li class="edit-option"><i class="fas fa-edit"></i> Edit</li>
                                                    <li class="delete-option"><i class="fas fa-trash-alt"></i> Delete</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="msg_cotainer_send">
                                            <div style="white-space: pre-wrap; min-width: 80px; display: flex; justify-content: start">${privateMessage.content}</div>
                                            <span class="msg_time_send">${privateMessage.created_at}</span>
                                        </div>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="./src/images/profile-picture/${senderProfilePicture}" class="rounded-circle user_img_msg">
                                    </div>
                                </div>
                            `;
                                messagesContainer.innerHTML += senderMessage;
                            } else {
                                const receiverMessage = `
                                <div class="d-flex justify-content-start mb-4 message-container" style="margin-right:15px" data-message-id="${privateMessage.id}">
                                    <div class="img_cont_msg">
                                        <img src="./src/images/profile-picture/${receiverProfilePicture}" class="rounded-circle user_img_msg">
                                    </div>
                                    <div style="display: flex; justify-content: center; align-items:center">
                                        <div class="msg_cotainer">
                                            <div style="white-space: pre-wrap; min-width: 80px; display: flex; justify-content: start">${privateMessage.content}</div>
                                            <span class="msg_time">${privateMessage.created_at}</span>
                                        </div>
                                        <div class="relative-container" id="receiver">
                                            <span class="action_menu_btn" style="cursor: pointer; padding: 5px"><i class="fas fa-ellipsis-v" style="color: #b8daff;"></i></span>
                                            <div class="action_menu">
                                                <ul>
                                                    <li class="delete-option"><i class="fas fa-trash-alt"></i> Delete</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                                messagesContainer.innerHTML += receiverMessage;
                            }
                        });
                    } else {
                        messagesContainer.innerHTML = '<p>No messages available.</p>';
                    }
                })
                .catch(error => console.error('Error fetching messages:', error));
        }
        setInterval(getMessages, 1000)
    });
</script>