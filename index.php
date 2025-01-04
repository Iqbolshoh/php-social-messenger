<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$sender_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Chat</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
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
                            <span>${user.full_name}</span>
                            <p>${user.username}</p>
                        </div>
                    </div>
                    `;
                            contactsList.appendChild(listItem);
                        });
                    }
                })
        }

        fetchContacts();
    </script>

</body>

</html>