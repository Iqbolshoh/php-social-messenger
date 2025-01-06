<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page About API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #fff;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            font-size: 3rem;
            color: #333;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .list-group-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .list-group-item h5 {
            color: #007bff;
            font-weight: bold;
        }

        .list-group-item p {
            color: #555;
            margin: 5px 0;
        }

        .badge {
            background-color: #28a745;
            padding: 0.4rem;
            border-radius: 8px;
            color: #fff;
        }

        footer {
            text-align: center;
            margin-top: 60px;
            font-size: 1rem;
            color: #777;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 20px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>API Documentation</h1>

        <section>
            <h2>Authentication APIs</h2>
            <div class="list-group">
                <div class="list-group">
                    <div class="list-group-item">
                        <h5><strong>1) login.php</strong></h5>

                        <p><strong>Purpose:</strong> This API is used for user authentication (Login). It verifies the username and password provided by the user, and if correct, logs the user in and starts a session. Additionally, cookies are set for persistent login to keep the user logged in across different sessions.</p>

                        <p><strong>Method:</strong> <code>POST</code></p>

                        <p><strong>Required Data:</strong>
                        <ul>
                            <li><strong><code>username</code></strong>: The username of the user (a string).</li>
                            <li><strong><code>password</code></strong>: The password of the user (a string).</li>
                        </ul>
                        </p>

                        <p><strong>Response:</strong> The API returns a JSON response indicating whether the login attempt was successful or not.</p>

                        <ul>
                            <li><strong>If Login is Successful:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                    <li><strong>Message:</strong> Login successful</li>
                                    <li><strong>Data:</strong> JSON object with user details (user_id, full_name, email, username, profile_picture).</li>
                                </ul>
                            </li>
                            <li><strong>If Login Fails:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                    <li><strong>Message:</strong> Incorrect username or password / No user found with that username</li>
                                </ul>
                            </li>
                        </ul>

                        <p><strong>Example Request:</strong></p>
                        <code>
                            <pre>
POST /api/auth/login.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

username=johndoe&password=yourpassword
                            </pre>
                        </code>

                        <p><strong>Example Response:</strong></p>
                        <code>
                            <pre>
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "loggedin": true,
        "user_id": 1,
        "full_name": "John Doe",
        "email": "johndoe@example.com",
        "username": "johndoe",
        "profile_picture": "path/to/profile.jpg"
    }
}
                            </pre>
                        </code>

                        <p><strong>Notes:</strong> On success, a session is started for the user, and two cookies are set: <code>username</code> and <code>session_token</code> for persistent login.</p>

                        <span class="badge bg-primary">POST</span>
                    </div>

                    <div class="list-group-item">
                        <h5><strong>2) signup.php</strong></h5>

                        <p><strong>Purpose:</strong> This API is used for user registration (Sign Up). It accepts user details such as username, email, and password, and creates a new user account in the system. After successful registration, the user is logged in automatically, and a session is started.</p>

                        <p><strong>Method:</strong> <code>POST</code></p>

                        <p><strong>Required Data:</strong>
                        <ul>
                            <li><strong><code>username</code></strong>: The desired username for the new user (a string).</li>
                            <li><strong><code>email</code></strong>: The user's email address (a string).</li>
                            <li><strong><code>password</code></strong>: The password the user chooses (a string).</li>
                            <li><strong><code>confirm_password</code></strong>: The confirmation of the password to ensure the user typed it correctly (a string).</li>
                        </ul>
                        </p>

                        <p><strong>Response:</strong> The API will return a JSON response indicating whether the registration attempt was successful or not.</p>

                        <ul>
                            <li><strong>If Registration is Successful:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                    <li><strong>Message:</strong> Registration successful</li>
                                    <li><strong>Data:</strong> JSON object with user details (user_id, full_name, email, username, profile_picture).</li>
                                </ul>
                            </li>
                            <li><strong>If Registration Fails:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                    <li><strong>Message:</strong> Registration failed. Please try again later.</li>
                                </ul>
                            </li>
                        </ul>

                        <p><strong>Example Request:</strong></p>
                        <code>
                            <pre>
POST /api/auth/signup.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

username=johndoe&email=johndoe@example.com&password=yourpassword&confirm_password=yourpassword
        </pre>
                        </code>

                        <p><strong>Example Response:</strong></p>
                        <code>
                            <pre>
{
    "status": "success",
    "message": "Registration successful",
    "data": {
        "loggedin": true,
        "user_id": 1,
        "full_name": "John Doe",
        "email": "johndoe@example.com",
        "username": "johndoe",
        "profile_picture": "default.png"
    }
}
        </pre>
                        </code>

                        <p><strong>Notes:</strong> After a successful registration, the user is automatically logged in, and a session is created. Two cookies are also set: <code>username</code> and <code>session_token</code> for persistent login across sessions.</p>

                        <span class="badge bg-primary">POST</span>
                    </div>

                    <div class="list-group-item">
                        <h5><strong>3) check_login.php</strong></h5>
                        <p><strong>Purpose:</strong> Checks if the user is logged in</p>
                        <p><strong>Method:</strong> GET</p>
                        <p><strong>Response:</strong> Returns login status (Logged in or not).</p>
                        <span class="badge">GET</span>
                    </div>
                    <div class="list-group-item">
                        <h5><strong>4) check_user_status.php</strong></h5>
                        <p><strong>Purpose:</strong> Verifies the user's login status</p>
                        <p><strong>Method:</strong> GET</p>
                        <p><strong>Response:</strong> Returns user status (active, inactive, or not logged in).</p>
                        <span class="badge">GET</span>
                    </div>
                </div>


                <div class="list-group-item">
                    <h5><strong>2) signup.php</strong></h5>
                    <p><strong>Purpose:</strong> User registration (Sign Up)</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Required data:</strong> <code>username</code>, <code>email</code>, <code>password</code>, <code>confirm_password</code></p>
                    <p><strong>Response:</strong> Success message or error message.</p>
                    <span class="badge">POST</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>3) check_login.php</strong></h5>
                    <p><strong>Purpose:</strong> Checks if the user is logged in</p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Response:</strong> Returns login status (Logged in or not).</p>
                    <span class="badge">GET</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>4) check_user_status.php</strong></h5>
                    <p><strong>Purpose:</strong> Verifies the user's login status</p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Response:</strong> Returns user status (active, inactive, or not logged in).</p>
                    <span class="badge">GET</span>
                </div>
            </div>
        </section>

        <section>
            <h2>Message APIs</h2>
            <div class="list-group">
                <div class="list-group-item">
                    <h5><strong>5) send_message.php</strong></h5>
                    <p><strong>Purpose:</strong> Sends a new message to another user</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Required data:</strong> <code>recipient_id</code>, <code>message_content</code></p>
                    <p><strong>Response:</strong> Success or error message.</p>
                    <span class="badge">POST</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>6) fetch_messages.php</strong></h5>
                    <p><strong>Purpose:</strong> Retrieves all messages for the logged-in user</p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Response:</strong> JSON response with a list of messages.</p>
                    <span class="badge">GET</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>7) delete_message.php</strong></h5>
                    <p><strong>Purpose:</strong> Deletes a specific message</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Required data:</strong> <code>message_id</code></p>
                    <p><strong>Response:</strong> Success or error message.</p>
                    <span class="badge">POST</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>8) edit_message.php</strong></h5>
                    <p><strong>Purpose:</strong> Edits an existing message</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Required data:</strong> <code>message_id</code>, <code>new_message_content</code></p>
                    <p><strong>Response:</strong> Success or error message.</p>
                    <span class="badge">POST</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>9) clear_messages.php</strong></h5>
                    <p><strong>Purpose:</strong> Clears all messages for the logged-in user</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Response:</strong> Success or error message.</p>
                    <span class="badge">POST</span>
                </div>
            </div>
        </section>

        <section>
            <h2>Other Helper APIs</h2>
            <div class="list-group">
                <div class="list-group-item">
                    <h5><strong>10) fetch_contacts.php</strong></h5>
                    <p><strong>Purpose:</strong> Retrieves the list of contacts for the logged-in user</p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Response:</strong> JSON response with the list of contacts.</p>
                    <span class="badge">GET</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>11) fetch_profile.php</strong></h5>
                    <p><strong>Purpose:</strong> Retrieves the user's profile information</p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Response:</strong> JSON response with profile data.</p>
                    <span class="badge">GET</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>12) change_user_status.php</strong></h5>
                    <p><strong>Purpose:</strong> Changes the user's online/offline status</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Required data:</strong> <code>status</code> (online or offline)</p>
                    <p><strong>Response:</strong> Success or error message.</p>
                    <span class="badge">POST</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>13) check_availability.php</strong></h5>
                    <p><strong>Purpose:</strong> Checks if the system or a specific feature is available</p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Response:</strong> Availability status of the feature/system.</p>
                    <span class="badge">GET</span>
                </div>
            </div>
        </section>

        <footer>
            <p>© 2025 API Documentation Social-Messenger. All rights reserved.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>