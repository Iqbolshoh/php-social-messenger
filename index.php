<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];
$result = $query->select('users', '*', 'id = ?', [$sender_id], 'i');

if (isset($result[0])) {
    $user = $result[0];
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
        $uploadFileDir = './src/images/profile-picture/';
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

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Chat</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="./src/css/style.css">
</head>

<body>

    <script>
        function fetchContacts(searchTerm = '') {
            fetch('api/fetch_contacts.php?search=' + encodeURIComponent(searchTerm))
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const contacts = data.data;
                        const contactsList = document.getElementById('contacts-list');
                        contactsList.innerHTML = '';

                        contacts.forEach(user => {
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
                                    <div
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
                    }
                });
        }
    </script>

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <img src="./src/images/profile-picture/<?= $user['profile_picture']; ?>" alt="Profile Image" class="rounded-circle" width="50" height="50">
                        <h5 class="modal-title ml-3" id="profileModalLabel">Edit Profile</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="profile-form" action="" method="POST" enctype="multipart/form-data" class="profile-form">
                        <div class="form-group">
                            <label for="full_name" class="form-label">Full Name:</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" value="<?= $user['full_name'] ?>" required maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="profile_picture" class="form-label">Profile Image:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture" accept="image/*">
                                <label class="custom-file-label" for="profile_picture">Choose image</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= $user['email'] ?>" readonly maxlength="120">
                        </div>

                        <div class="form-group">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?= $user['username'] ?>" readonly maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">New Password:</label>
                            <input type="password" id="password" name="password" class="form-control" maxlength="255">
                            <small class="form-text text-muted">Leave empty if you don't want to change the password.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header" style="display: flex;">
                        <div class="input-group">
                            <span class="input-group-text menu_btn" data-toggle="modal" data-target="#profileModal">
                                <i class="fas fa-bars"></i>
                            </span>
                            <input type="text" placeholder="Search..." name="search" id="search" class="form-control search">
                            <div class="input-group-prepend">
                                <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <span class="input-group-prepend logout_menu" onclick="logout()">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                    </div>
                    <div class="card-body contacts_body">
                        <ul class="contacts" id="contacts-list"></ul>
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
        // Set Interval
        let fetchInterval = setInterval(fetchContacts, 1000);

        const searchInput = document.getElementById('search');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.trim();

            clearInterval(fetchInterval);

            if (timeout) {
                clearTimeout(timeout);
            }

            timeout = setTimeout(function() {
                fetchContacts(searchTerm);
            }, 1000);
        });

        searchInput.addEventListener('blur', function() {
            fetchInterval = setInterval(fetchContacts, 1000);
        });

        // Fetch Contact
        function fetchContacts(searchTerm = '') {
            fetch('api/fetch_contacts.php?search=' + encodeURIComponent(searchTerm))
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const contacts = data.data;
                        const contactsList = document.getElementById('contacts-list');
                        contactsList.innerHTML = '';

                        contacts.forEach(user => {
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
                                    <div
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
                    }
                });
        }

        function highlightSearchTerm(text, searchTerm) {
            if (!searchTerm) return text;
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            return text.replace(regex, '<span style="color: red;">$1</span>');
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