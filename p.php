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

$message_count = 0;

$sender_user = $query->select('users', '*', 'id = ?', [$sender_id], 'i')[0];
$receiver_user = $query->select('users', '*', 'id = ?', [$receiver_id], 'i')[0];

$private_messages = $query->select(
    'private_messages',
    '*',
    "((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)) ORDER BY created_at",
    [$sender_id, $receiver_id, $receiver_id, $sender_id],
    "iiii"
);

$message_count = count($private_messages);

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
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<style>
    .no-message {
        text-align: center;
        margin-top: 20px;
        padding: 55px 15px;
        background-color: #82ccdd;
        color: #212529;
        border: 1px solid #82ccdd;
        border-radius: 11px;
        font-size: 16px;
        font-weight: bold;
    }
</style>

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
                                <p><?= $message_count ?> Messages</p>
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

                    <div class="card-body msg_card_body">

                        <?php if (!empty($private_messages)) : ?>

                            <?php foreach ($private_messages as $private_message): ?>

                                <?php if ($sender_id == $private_message['sender_id']): ?>

                                    <div class="d-flex justify-content-end mb-4 message-container" style="margin-left:15px" data-message-id="<?= $private_message['id'] ?>">
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
                                                <div style="white-space: pre-wrap; min-width: 80px; display: flex; justify-content: start"><?= $private_message['content'] ?></div>
                                                <span class="msg_time_send"><?= $private_message['created_at'] ?></span>
                                            </div>
                                        </div>

                                        <div class="img_cont_msg">
                                            <img src="./src/images/profile-picture/<?= $sender_user['profile_picture'] ?>" class="rounded-circle user_img_msg">
                                        </div>
                                    </div>

                                <?php else : ?>

                                    <div class="d-flex justify-content-start mb-4 message-container" style="margin-right:15px" data-message-id="<?= $private_message['id'] ?>">
                                        <div class="img_cont_msg">
                                            <img src="./src/images/profile-picture/<?= $receiver_user['profile_picture'] ?>" class="rounded-circle user_img_msg">
                                        </div>

                                        <div style="display: flex; justify-content: center; align-items:center">
                                            <div class="msg_cotainer">
                                                <div style="white-space: pre-wrap; min-width: 80px; display: flex; justify-content: start"><?= $private_message['content'] ?></div>
                                                <span class="msg_time"><?= $private_message['created_at'] ?></span>
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

                                <?php endif ?>

                            <?php endforeach ?>

                        <?php else : ?>
                            <div class="no-message">
                                <i class="fas fa-comment-dots"></i>
                                The message is empty...
                            </div>
                        <?php endif ?>

                    </div>

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

    <script>
        let isOpen = null;

        document.querySelector('.msg_card_body').addEventListener('click', function(event) {
            if (event.target.closest('.action_menu_btn')) {
                event.stopPropagation();
                const actionMenu = event.target.closest('.message-container').querySelector('.action_menu');
                if (isOpen && isOpen !== actionMenu) {
                    isOpen.style.display = 'none';
                }
                if (actionMenu.style.display === 'none' || actionMenu.style.display === '') {
                    actionMenu.style.display = 'block';
                    isOpen = actionMenu;
                } else {
                    actionMenu.style.display = 'none';
                    isOpen = null;
                }
            }
        });

        document.querySelector('.send_btn').addEventListener('click', function(event) {
            event.preventDefault();
            const messageInput = document.querySelector('.type_msg');
            const message = messageInput.value.trim();
            if (!message) {
                Swal.fire('Error!', 'Please enter a message.', 'error');
                return;
            }
            const receiver_id = <?= $receiver_id ?>;
            $.ajax({
                url: 'send_message.php',
                method: 'POST',
                data: {
                    content: message,
                    receiver_id: receiver_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let messageContainer = `
                        <div class="d-flex justify-content-end mb-4 message-container" style="margin-left:15px" data-message-id="${response.data.id}">
                            <div style="display: flex; justify-content: center; align-items:center">
                                <div class="relative-container" id="sender">
                                    <span class="action_menu_btn" style="cursor: pointer; padding: 5px">
                                        <i class="fas fa-ellipsis-v" style="color: #78e08f;"></i>
                                    </span>
                                    <div class="action_menu" style="display: none;">
                                        <ul>
                                            <li class="edit-option"><i class="fas fa-edit"></i> Edit</li>
                                            <li class="delete-option"><i class="fas fa-trash-alt"></i> Delete</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="msg_cotainer_send">
                                    <div style="white-space: pre-wrap; min-width: 80px; display: flex; justify-content: start">${response.data.content}</div>
                                    <span class="msg_time_send">${response.data.created_at}</span>
                                </div>
                            </div>
                            <div class="img_cont_msg">
                                <img src="./src/images/profile-picture/<?= $sender_user['profile_picture'] ?>" class="rounded-circle user_img_msg">
                            </div>
                        </div>
                    `;
                        const messagesDiv = document.querySelector(".msg_card_body");
                        messagesDiv.innerHTML += messageContainer;
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                        messageInput.value = '';
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        });

        $(document).on('click', '.delete-option', function() {
            const messageId = $(this).closest('.message-container').data('message-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This message will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_message.php',
                        method: 'POST',
                        data: {
                            message_id: messageId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Deleted!', 'Your message has been deleted.', 'success');
                                $(`.message-container[data-message-id="${messageId}"]`).remove();
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.edit-option', function() {
            const messageContainer = event.target.closest('.message-container');
            const messageId = messageContainer.getAttribute('data-message-id');
            const messageElement = messageContainer.querySelector('.msg_cotainer_send div');
            const messageText = messageElement.textContent.trim();

            Swal.fire({
                title: 'Edit your message',
                input: 'textarea',
                inputValue: messageText,
                inputPlaceholder: 'Write your message here...',
                showCancelButton: true,
                confirmButtonText: 'Save changes',
                cancelButtonText: 'Cancel',
                inputAttributes: {
                    'aria-label': 'Type your message'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!';
                    }
                },
                customClass: {
                    input: 'swal2-textarea'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const newMessage = result.value;

                    $.ajax({
                        url: 'edit_message.php',
                        method: 'POST',
                        data: {
                            message_id: messageId,
                            new_message: newMessage
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                messageElement.textContent = newMessage;
                                Swal.fire('Updated!', response.message, 'success');
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll('.delete-option').forEach((deleteButton) => {
            deleteButton.addEventListener('click', function(event) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const messageContainer = event.target.closest('.message-container');
                        const messageId = messageContainer.getAttribute('data-message-id');

                        $.ajax({
                            url: 'delete_message.php',
                            method: 'POST',
                            data: {
                                message_id: messageId
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    messageContainer.remove();
                                    Swal.fire('Deleted!', response.message, 'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });
        });

        document.getElementById('clearBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to clear all?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'clear_all_message.php',
                        method: 'POST',
                        data: {
                            clear: true,
                            receiver_id: <?= json_encode($receiver_id) ?>
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Cleared!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>