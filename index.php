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

$username = $user['username'];
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

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="profile-container">
                        <div class="profile-form-container">
                            <div class="profile-header">
                                <img class="profile-picture" src="./src/images/profile-picture/<?= $user['profile_picture']; ?>"
                                    alt="Profile Image">
                                <h2 class="profile-name"><?= $user['username'] ?></h2>
                            </div>
                            <form id="profile-form" action="profile.php" method="POST" enctype="multipart/form-data"
                                class="profile-form">
                                <label for="full_name" class="form-label">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" class="form-input"
                                    value="<?= $user['full_name'] ?>" required maxlength="30">

                                <label for="profile_picture" class="form-label">Profile Image:</label>
                                <div class="custom-file-input">
                                    <input type="file" id="profile_picture" name="profile_picture" class="form-input"
                                        accept="image/*">
                                    <div class="file-input-content">
                                        <span class="file-label">Choose image</span>
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                </div>

                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-input" value="<?= $user['email'] ?>"
                                    readonly maxlength="120">

                                <label for="username" class="form-label">Username:</label>
                                <input type="text" id="username" name="username" class="form-input" value="<?= $username; ?>"
                                    readonly maxlength="30">

                                <label for="password" class="form-label">New Password:</label>
                                <div class="password-container">
                                    <input type="password" id="password" name="password" class="password-input"
                                        maxlength="255">
                                    <a type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></a>
                                </div>

                                <button type="submit" class="submit-button">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat UI -->
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header">
                        <div class="input-group">
                            <span class="input-group-text menu_btn" data-toggle="modal" data-target="#profileModal">
                                <i class="fas fa-bars"></i>
                            </span>
                            <input type="text" placeholder="Search..." name="search" id="search" class="form-control search">
                            <div class="input-group-prepend">
                                <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body contacts_body">
                        <ul class="contacts" id="contacts-list"></ul>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch and display contacts
        const searchInput = document.getElementById('search');
        let intervalId = null;

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.trim();

            if (searchTerm === '') {
                if (intervalId === null) {
                    intervalId = setInterval(() => fetchContacts(), 1000);
                }
            } else {
                clearInterval(intervalId);
                intervalId = null;
                fetchContacts(searchTerm);
            }
        });

        function fetchContacts(searchTerm = '') {
            fetch('fetch_contacts.php?search=' + encodeURIComponent(searchTerm))
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const contacts = data.data;
                        const contactsList = document.getElementById('contacts-list');
                        contactsList.innerHTML = '';

                        contacts.forEach(user => {
                            const highlightedFullName = highlightSearchTerm(user.full_name, searchTerm);
                            const highlightedUsername = highlightSearchTerm(user.username, searchTerm);

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
    </script>

    <!-- Bootstrap JS (requires jQuery and Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</body>

</html>