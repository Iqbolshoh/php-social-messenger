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
<style>
    .no-messages {
        text-align: center;
        color: #fff;
        background-color: #f1c40f;
        padding: 20px;
        border-radius: 8px;
        font-size: 18px;
        margin-top: 50px;
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
                                <p><b style="font-weight:normal"></b> Messages</p>
                            </div>
                        </div>
                        <span id="action_menu_btn_user" style="padding: 5px;" onclick="createMenu(null, null)">
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="action_menu_user" style="display: none;">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script>
        // Fetch Message
        document.addEventListener("DOMContentLoaded", function() {
            const receiverId = <?= $receiver_id ?>;
            const senderId = <?= $sender_id ?>;
            const senderProfilePicture = "<?= $sender_user['profile_picture'] ?>";
            const receiverProfilePicture = "<?= $receiver_user['profile_picture'] ?>";
            let countScrollHeight = 0;

            const messagesContainer = document.getElementById('messages-container');

            function LoadMessages() {
                $.ajax({
                    url: 'fetch_messages.php',
                    type: 'POST',
                    data: {
                        id: receiverId
                    },
                    dataType: 'json',
                    success: function(privateMessages) {
                        if (privateMessages && privateMessages.length > 0) {
                            messagesContainer.innerHTML = '';
                            privateMessages.forEach(privateMessage => {
                                const isSender = privateMessage.sender_id === senderId;

                                document.querySelector('.user_info p b').textContent = privateMessages.length;

                                if (isSender) {
                                    const senderMessage = `
                            <div class="d-flex justify-content-end mb-4 message-container" style="margin-left:15px" data-message-id="${privateMessage.id}" id="sender">
                                <div style="display: flex; justify-content: center; align-items:center">
                                    <div class="relative-container" id="sender">
                                        <span class="action_menu_btn" style="cursor: pointer; padding: 5px"><i class="fas fa-ellipsis-v" style="color: #78e08f;"></i></span>
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
                            <div class="d-flex justify-content-start mb-4 message-container" style="margin-right:15px" data-message-id="${privateMessage.id}" id="receiver">
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
                                    </div>
                                </div>
                            </div>
                        `;
                                    messagesContainer.innerHTML += receiverMessage;
                                }
                            });

                            if (countScrollHeight == 0) {
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                                countScrollHeight++;
                            }
                        } else {
                            messagesContainer.innerHTML = '<p class="no-messages">No messages available.</p>';
                        }
                    }
                });
            }

            LoadMessages();
            setInterval(LoadMessages, 1000);
        });
    </script>
    <script>
        let isOpen = null;

        function createMenu(id, user) {
            const action_menu_user = document.querySelector('.action_menu_user');

            if (id == null && user == null) {
                action_menu_user.innerHTML = `<ul>
            <li><i class="fas fa-user-circle"></i> View profile</li>
            <li style="color: orange" onclick="clearMessages()"><i class="fas fa-times-circle"></i> Clear</li>
            <li style="color: red"><i class="fas fa-ban"></i> Block</li>
        </ul>`;
            } else if (user == 'sender') {
                action_menu_user.innerHTML = `<ul>
            <li class="edit-option" onclick="edit(${id})"><i class="fas fa-edit"></i> Edit</li>
            <li class="delete-option" onclick="deleteMessage(${id})"><i class="fas fa-trash-alt"></i> Delete</li>
        </ul>`;
            } else {
                action_menu_user.innerHTML = `<ul>
            <li class="delete-option" onclick="deleteMessage(${id})"><i class="fas fa-trash-alt"></i> Delete</li>
        </ul>`;
            }
        }

        function toggleActionMenu(event, actionMenuSelector) {
            event.stopPropagation();

            var actionMenu = document.querySelector(actionMenuSelector);

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

        document.getElementById('action_menu_btn_user').addEventListener('click', function(event) {
            toggleActionMenu(event, '.action_menu_user');
        });

        document.querySelector('.msg_card_body').addEventListener('click', function(event) {
            if (event.target.closest('.action_menu_btn')) {
                const messageContainer = event.target.closest('.message-container');
                const messageId = messageContainer ? messageContainer.getAttribute('data-message-id') : null;

                createMenu(messageId, messageContainer.id);

                toggleActionMenu(event, '.action_menu_user');
            }
        });

        document.querySelector('.action_menu_user').addEventListener('click', function(event) {
            if (event.target.closest('li') && event.target.closest('li').textContent.trim() === 'View profile') {
                const modal = document.getElementById('profileModal');
                modal.classList.add('show');
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });

        document.getElementById('closeModalBtn').addEventListener('click', function() {
            const modal = document.getElementById('profileModal');
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        document.getElementById('profileModal').addEventListener('click', function(event) {
            const modalContent = document.querySelector('.modal-content');
            if (!modalContent.contains(event.target)) {
                const modal = document.getElementById('profileModal');
                modal.classList.remove('show');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        document.addEventListener('click', function(event) {
            if (isOpen && !isOpen.contains(event.target) && !event.target.closest('.action_menu_btn') && !event.target.closest('#action_menu_btn_user')) {
                isOpen.style.display = 'none';
                isOpen = null;
            }
        });
    </script>

    <script>
        // Send Message
        document.querySelector('.send_btn').addEventListener('click', function(event) {
            event.preventDefault();
            const messageInput = document.querySelector('.type_msg');
            const message = messageInput.value.trim();

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
                        <div class="d-flex justify-content-end mb-4 message-container" style="margin-left:15px" data-message-id="${response.data.id}" id="sender">
                            <div style="display: flex; justify-content: center; align-items:center">
                                <div class="relative-container" id="sender">
                                    <span class="action_menu_btn" style="cursor: pointer; padding: 5px">
                                        <i class="fas fa-ellipsis-v" style="color: #78e08f;"></i>
                                    </span>
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
                    }
                }
            });
        });

        // Edit Message
        function edit(messageId) {
            const messageContainer = document.querySelector(`.message-container[data-message-id="${messageId}"]`);

            if (messageContainer) {
                const messageElement = messageContainer.querySelector('.msg_cotainer_send div');

                if (messageElement) {
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
                                        Swal.fire({
                                            title: 'Updated!',
                                            text: response.message,
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire('Error!', 'Message content not found. Please try again.', 'error');
                }
            } else {
                Swal.fire('Error!', 'Message container not found. Please try again.', 'error');
            }
        }

        // Delete Message 
        function deleteMessage(messageId) {
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
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Your message has been deleted.',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                $(`.message-container[data-message-id="${messageId}"]`).remove();

                                let countElement = document.querySelector('.user_info p b');
                                if (countElement) {
                                    let currentCount = parseInt(countElement.textContent.trim());
                                    if (!isNaN(currentCount) && currentCount > 0) {
                                        countElement.textContent = currentCount - 1;
                                    }
                                }
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }
                    });
                }
            });
        }

        function clearMessages() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to clear all messages?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {

                    const receiverId = <?= $receiver_id ?>;

                    $.ajax({
                        url: 'clear_messages.php',
                        method: 'POST',
                        data: {
                            clear: true,
                            receiver_id: receiverId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Cleared!', response.message, 'success').then(() => {
                                    let countElement = document.querySelector('.user_info p b');
                                    if (countElement) {
                                        let currentCount = parseInt(countElement.textContent.trim());
                                        countElement.textContent = 0;
                                    }
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>