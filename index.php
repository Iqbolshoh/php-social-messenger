<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social-Messenger | Contacts</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/profile-modal.css">
    <style>
        /* --- Profile Modal Creative Style --- */
        #profileModal .modal-content {
            background: linear-gradient(120deg, #91EAE4 0%, #86A8E7 70%, #7F7FD5 100%);
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(127, 127, 213, 0.22), 0 1.5px 7px 0 rgba(100, 100, 200, 0.18);
            backdrop-filter: blur(3px);
            padding: 0;
            color: #32325d;
            animation: fadeInUp 0.5s cubic-bezier(.77, 0, .18, 1.01);
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px) scale(0.97);
                opacity: 0;
            }

            to {
                transform: none;
                opacity: 1;
            }
        }

        #profileModal .modal-header {
            border: none;
            padding: 1.2rem 2rem 0.5rem 2rem;
            background: transparent;
        }

        #profileModal .modal-title {
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #7F7FD5;
            font-size: 1.5rem;
        }

        #profileModal .close {
            color: #7F7FD5;
            opacity: 1;
            font-size: 2.1rem;
            transition: color .18s;
        }

        #profileModal .close:hover {
            color: #23236E;
            background: none;
        }

        #profileModal .modal-body {
            padding: 1rem 2rem 2rem 2rem;
            background: transparent;
        }

        #profileModal .text-center img,
        #profileModal #modalProfilePicture {
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 2px 15px #91EAE4aa;
            margin-bottom: 18px;
            width: 110px;
            height: 110px;
            object-fit: cover;
            background: #e6eaff;
        }

        #profileModal .form-group label {
            color: #7F7FD5;
            font-weight: 600;
            margin-bottom: 7px;
            letter-spacing: 0.05em;
        }

        #profileModal .form-control,
        #profileModal .custom-file-label {
            background: rgba(255, 255, 255, 0.89);
            border: 2px solid #86A8E7;
            border-radius: 8px;
            font-size: 1.06rem;
            color: #233050;
            margin-bottom: 8px;
            transition: border 0.16s;
        }

        #profileModal .form-control:focus {
            border: 2px solid #7F7FD5;
            background: #f4fafe;
            box-shadow: 0 0 0 2.5px #91EAE4;
        }

        #profileModal .custom-file-label {
            cursor: pointer;
            color: #7F7FD5;
            font-weight: 500;
            border-radius: 8px;
        }

        #profileModal .btn-primary {
            background: linear-gradient(90deg, #91EAE4 0%, #7F7FD5 100%);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 1.06rem;
            font-weight: 700;
            box-shadow: 0 2px 10px 0 rgba(127, 127, 213, 0.16);
            transition: background 0.18s, box-shadow 0.18s, transform 0.12s;
            margin-top: 12px;
            padding: 10px 0;
            width: 100%;
        }

        #profileModal .btn-primary:hover {
            background: linear-gradient(90deg, #7F7FD5 0%, #91EAE4 100%);
            box-shadow: 0 2px 18px 0 rgba(127, 127, 213, 0.25);
            transform: translateY(-2px) scale(1.017);
        }

        #profileModal .invalid-feedback {
            display: block;
            color: #d02c6d;
            font-size: 0.99rem;
            margin-top: -8px;
            margin-bottom: 8px;
        }

        @media (max-width: 500px) {
            #profileModal .modal-dialog {
                margin: 6vw;
            }

            #profileModal .modal-content {
                padding: 0;
            }

            #profileModal .modal-body,
            #profileModal .modal-header {
                padding-left: 1vw;
                padding-right: 1vw;
            }
        }
    </style>
</head>

<body>
    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <div class="d-flex align-items-center">
                        <img src="./src/images/profile-picture/default.png" alt="Profile Image" class="rounded-circle" width="50" height="50" id="modalProfilePicture">
                        <h5 class="modal-title ml-3" id="profileModalLabel">Edit Profile</h5>
                    </div>
                    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size:2rem;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="profile-form" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-group mb-3 text-center">
                            <img src="./src/images/profile-picture/default.png" alt="Profile" id="modalProfilePicture" width="110" height="110">
                        </div>
                        <div class="form-group mb-3">
                            <label for="full_name" class="form-label">Full Name:</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" required maxlength="30" placeholder="Enter your full name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="profile_picture" class="form-label">Profile Image:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture" accept="image/*">
                                <label class="custom-file-label" for="profile_picture">Choose an image</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">New Password:</label>
                            <input type="password" id="password" name="password" class="form-control" maxlength="255" placeholder="Enter new password">
                        </div>
                        <div class="form-group mb-4">
                            <label for="confirm_password" class="form-label">Confirm New Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" maxlength="255" placeholder="Re-type new password">
                            <div class="invalid-feedback" id="confirm-password-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Chat Layout -->
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="input-group">
                            <span class="input-group-text menu_btn" data-toggle="modal" data-target="#profileModal">
                                <i class="fas fa-bars"></i>
                            </span>
                            <input type="text" placeholder="Search..." name="search" id="search" class="form-control search">
                            <div class="input-group-prepend">
                                <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <span class="input-group-prepend logout_menu" onclick="logout()" style="cursor:pointer" title="Log out">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                    </div>
                    <div class="card-body contacts_body">
                        <ul class="contacts" id="contacts-list"></ul>
                        <div id="contacts-empty" class="text-center text-muted mt-5" style="display:none;">No contacts found.</div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        // Fetch user profile info
        function fetchUserProfile() {
            fetch('./api/fetch_profile.php')
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        const {
                            full_name,
                            email,
                            username,
                            profile_picture
                        } = result.data;
                        document.getElementById('full_name').value = full_name;
                        document.getElementById('email').value = email;
                        document.getElementById('username').value = username;
                        const profilePic = profile_picture && profile_picture !== 'default.png' ?
                            './src/images/profile-picture/' + profile_picture :
                            './src/images/profile-picture/default.png';
                        // Set both modal images
                        document.querySelectorAll('#modalProfilePicture').forEach(img => img.src = profilePic);
                    }
                });
        }
        // Profile form password confirm validation
        document.getElementById('profile-form').addEventListener('input', function() {
            const pass = document.getElementById('password').value;
            const conf = document.getElementById('confirm_password').value;
            const errorElem = document.getElementById('confirm-password-error');
            if (pass !== conf && conf.length > 0) {
                errorElem.textContent = "Passwords do not match!";
            } else {
                errorElem.textContent = "";
            }
        });
        // On submit, prevent save if not valid!
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            const pass = document.getElementById('password').value;
            const conf = document.getElementById('confirm_password').value;
            const errorElem = document.getElementById('confirm-password-error');
            if (pass !== conf) {
                errorElem.textContent = "Passwords do not match!";
                e.preventDefault();
                return false;
            }
            // AJAX submit
            e.preventDefault();
            const formData = new FormData(this);
            fetch('./api/fetch_profile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated',
                        text: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => window.location.reload());
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Failed to connect to the server. Please try again later.',
                    });
                });
        });
        fetchUserProfile();

        // Contacts search and polling
        let fetchInterval = setInterval(fetchContacts, 1000);
        const searchInput = document.getElementById('search');
        let timeout = null;
        searchInput.addEventListener('input', function() {
            clearInterval(fetchInterval);
            if (timeout) clearTimeout(timeout);
            timeout = setTimeout(function() {
                fetchContacts(searchInput.value.trim());
            }, 500);
        });
        searchInput.addEventListener('blur', function() {
            fetchInterval = setInterval(fetchContacts, 1000);
        });

        function fetchContacts(searchTerm = '') {
            fetch('./api/fetch_contacts.php?search=' + encodeURIComponent(searchTerm))
                .then(response => response.json())
                .then(data => {
                    const contactsList = document.getElementById('contacts-list');
                    const contactsEmpty = document.getElementById('contacts-empty');
                    contactsList.innerHTML = '';
                    if (data.status === 'success' && data.data.length > 0) {
                        contactsEmpty.style.display = 'none';
                        data.data.forEach(user => {
                            const highlightedFullName = highlightSearchTerm(user.full_name, searchTerm);
                            const highlightedUsername = highlightSearchTerm(user.username, searchTerm);
                            const unreadMessages = user.unread_messages;
                            const listItem = document.createElement('li');
                            listItem.setAttribute('onclick', `window.location.href='chat.php?id=${user.user_id}'`);
                            listItem.innerHTML = `
                                <div class="d-flex bd-highlight">
                                    <div class="img_cont">
                                        <img src="./src/images/profile-picture/${user.profile_picture}" 
                                            class="rounded-circle user_img" 
                                            alt="${user.full_name}">
                                    </div>
                                    <div class="user_info">
                                        <span>${highlightedFullName}</span>
                                        <p>${highlightedUsername}</p>
                                    </div>
                                    <div class="message_count">
                                        ${unreadMessages > 0 ? `<span class="badge badge-warning">${unreadMessages}</span>` : ''}
                                    </div>
                                </div>
                            `;
                            contactsList.appendChild(listItem);
                        });
                    } else {
                        contactsEmpty.style.display = 'block';
                    }
                });
        }

        function highlightSearchTerm(text, searchTerm) {
            if (!searchTerm) return text;
            const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            return text.replace(regex, '<span style="color: #e43c5a;">$1</span>');
        }
        fetchContacts();

        // Logout function
        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to log out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './logout/';
                }
            });
        }
    </script>
</body>

</html>