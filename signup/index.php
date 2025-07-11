<?php

session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../src/css/login_signup.css">
</head>

<body>
    <div class="form-container">
        <h1>Sign Up</h1>
        <form id="signupForm">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required maxlength="30">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required maxlength="150">
                <p id="email-message"></p>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required maxlength="30">
                <p id="username-message"></p>
                <small id="username-error" style="color: red;"></small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required maxlength="255">
                    <button type="button" id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></button>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="password-container">
                    <input type="password" id="confirm_password" name="confirm_password" required maxlength="255">
                    <button type="button" id="toggle-confirm-password" class="password-toggle"><i class="fas fa-eye"></i></button>
                </div>
                <small id="confirm-password-error" style="color: #e43c5a; font-weight:600"></small>
            </div>
            <div class="form-group">
                <button type="submit" id="submit">Sign Up</button>
            </div>
        </form>
        <div class="text-center">
            <p>Already have an account? <a href="../login/">Login</a></p>
        </div>
    </div>
    <script src="../src/js/sweetalert2.js"></script>
    <script>
        let isEmailAvailable = false;
        let isUsernameAvailable = false;

        document.getElementById('email').addEventListener('input', function() {
            let email = this.value;
            if (email.length > 0) {
                fetch('../api/auth/check_availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `email=${encodeURIComponent(email)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        const messageElement = document.getElementById('email-message');
                        if (data.exists) {
                            messageElement.textContent = 'This email exists!';
                            isEmailAvailable = false;
                        } else {
                            messageElement.textContent = '';
                            isEmailAvailable = true;
                        }
                    });
            }
        });

        document.getElementById('username').addEventListener('input', function() {
            validateForm();
            let username = this.value;
            if (username.length > 0) {
                fetch('../api/auth/check_availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `username=${encodeURIComponent(username)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        const messageElement = document.getElementById('username-message');
                        if (data.exists) {
                            messageElement.textContent = 'This username exists!';
                            isUsernameAvailable = false;
                        } else {
                            messageElement.textContent = '';
                            isUsernameAvailable = true;
                        }
                    });
            }
        });

        function validateEmailFormat(email) {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return emailPattern.test(email);
        }

        function validateForm() {
            const usernameField = document.getElementById('username');
            const usernameError = document.getElementById('username-error');
            const submitButton = document.getElementById('submit');
            const username = usernameField.value;
            const usernamePattern = /^[a-zA-Z0-9_]+$/;
            if (!usernamePattern.test(username)) {
                usernameError.textContent = "Username can only contain letters, numbers, and underscores!";
                submitButton.disabled = true;
            } else {
                usernameError.textContent = "";
                submitButton.disabled = false;
            }
        }

        // Confirm password validation
        function validatePasswordsMatch() {
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();
            const errorElem = document.getElementById('confirm-password-error');
            const submitButton = document.getElementById('submit');
            if (confirmPassword.length > 0 && password !== confirmPassword) {
                errorElem.textContent = "Passwords do not match!";
                submitButton.disabled = true;
                return false;
            } else {
                errorElem.textContent = "";
                // Don't enable submit if other validation fails!
                validateForm();
                return true;
            }
        }
        document.getElementById('confirm_password').addEventListener('input', validatePasswordsMatch);
        document.getElementById('password').addEventListener('input', validatePasswordsMatch);

        document.getElementById('signupForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let email = document.getElementById('email').value;
            const messageElement = document.getElementById('email-message');
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();
            const confirmPasswordError = document.getElementById('confirm-password-error');

            if (!validateEmailFormat(email)) {
                messageElement.textContent = 'Email format is incorrect!';
                return;
            }

            if (isEmailAvailable === false) {
                messageElement.textContent = 'This email exists!';
                return;
            }

            if (isUsernameAvailable === false) {
                const usernameMessageElement = document.getElementById('username-message');
                usernameMessageElement.textContent = 'This username exists!';
                return;
            }

            if (password !== confirmPassword) {
                confirmPasswordError.textContent = "Passwords do not match!";
                return;
            } else {
                confirmPasswordError.textContent = "";
            }

            const formData = new FormData(this);

            fetch('../api/auth/signup.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registration Successful!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '../';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred, please try again.',
                    });
                });
        });

        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggle-confirm-password').addEventListener('click', function() {
            const confirmPasswordField = document.getElementById('confirm_password');
            const toggleIcon = this.querySelector('i');
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>