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
                        <p><strong>Purpose:</strong> Checks if the user is logged in. This API verifies whether the user is currently logged into the system. If the user is logged in, it returns the user's details. If not, it will return a message stating that the user is not logged in.</p>

                        <p><strong>Method:</strong> <code>GET</code></p>

                        <p><strong>Response:</strong> The API returns a JSON response indicating the login status of the user.</p>

                        <ul>
                            <li><strong>If User is Logged In:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                    <li><strong>Message:</strong> User is logged in</li>
                                    <li><strong>Data:</strong> JSON object containing user details (user_id, full_name, email, username, profile_picture).</li>
                                </ul>
                            </li>
                            <li><strong>If User is Not Logged In:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                    <li><strong>Message:</strong> User is not logged in</li>
                                </ul>
                            </li>
                        </ul>

                        <p><strong>Example Request:</strong></p>
                        <code>
                            <pre>
GET /api/auth/check_login.php HTTP/1.1
Content-Type: application/json
                            </pre>
                        </code>


                        <p><strong>Example Response:</strong></p>
                        <code>
                            <pre>
    {
        "status": "success",
        "message": "User is logged in",
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


                        <p><strong>Notes:</strong> If the user is logged in, their session information will be returned as part of the response. If the user is not logged in, the response will indicate that the user is not logged in.</p>

                        <span class="badge bg-primary">GET</span>
                    </div>

                    <div class="list-group-item">
                        <h5><strong>4) check_availability.php</strong></h5>
                        <p><strong>Purpose:</strong> Verifies if a given email or username is already registered in the system. This API helps to check if a user can use a particular email address or username during registration.</p>

                        <p><strong>Method:</strong> <code>POST</code></p>

                        <p><strong>Required Data:</strong>
                        <ul>
                            <li><strong><code>email</code></strong> (optional): The email address to check for availability.</li>
                            <li><strong><code>username</code></strong> (optional): The username to check for availability.</li>
                        </ul>
                        </p>

                        <p><strong>Response:</strong> The API returns a JSON response indicating whether the email or username is available or already taken.</p>

                        <ul>
                            <li><strong>If Email/Username is Available:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                    <li><strong>Message:</strong> Email or username is available</li>
                                    <li><strong>Data:</strong> <code>exists: false</code></li>
                                </ul>
                            </li>
                            <li><strong>If Email/Username is Already Taken:</strong>
                                <ul>
                                    <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                    <li><strong>Message:</strong> Email or username is already taken</li>
                                    <li><strong>Data:</strong> <code>exists: true</code></li>
                                </ul>
                            </li>
                        </ul>

                        <p><strong>Example Request:</strong></p>
                        <code>
                            <pre>
POST /api/auth/check_availability.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

email=johndoe@example.com
                            </pre>
                        </code>

                        <p><strong>Example Response:</strong></p>
                        <code>
                            <pre>
{
    "exists": true
}
                            </pre>
                        </code>

                        <p><strong>Notes:</strong> The API checks whether a given email address or username is already registered. It can return a status indicating if the email/username is available or taken. The request must provide either the <code>email</code> or <code>username</code> field.</p>

                        <span class="badge bg-primary">POST</span>
                    </div>

                </div>
            </div>
        </section>

        <section>
            <h2>Message APIs</h2>
            <div class="list-group">
                <div class="list-group-item">
                    <h5><strong>5) send_message.php</strong></h5>
                    <p><strong>Purpose:</strong> Sends a new message to another user. This API allows a user to send a message to another registered user within the system. The message will be stored in the database and can be retrieved later.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required Data:</strong>
                    <ul>
                        <li><strong><code>recipient_id</code></strong>: The ID of the user to whom the message will be sent.</li>
                        <li><strong><code>message_content</code></strong>: The content of the message to be sent.</li>
                    </ul>
                    </p>

                    <p><strong>Response:</strong> The API returns a success or error message depending on whether the message was sent successfully.</p>

                    <ul>
                        <li><strong>If Message Sent Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> Message sent successfully</li>
                                <li><strong>Data:</strong> JSON object with message details (id, content, created_at).</li>
                            </ul>
                        </li>
                        <li><strong>If Message Sending Failed:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> Failed to send the message. Please try again later.</li>
                            </ul>
                        </li>
                        <li><strong>If Required Data Missing:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> Message content and receiver ID are required.</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/messages/send_message HTTP/1.1
Content-Type: application/x-www-form-urlencoded

recipient_id=2&message_content=Hello%20there!
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "Message sent successfully",
    "data": {
        "id": 123,
        "content": "Hello there!",
        "created_at": "2025-01-06 15:30:00"
    }
}
        </pre>
        
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>If the user is not logged in, the API will return an error indicating the user is not logged in.</li>
                        <li>Both the recipient's ID and message content are required fields to send a message.</li>
                        <li>In case of a database issue or failure to insert the message, an error message will be returned.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
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
                    <h5><strong>13) check_user_status.php</strong></h5>
                    <p><strong>Purpose:</strong> Changes the user's online/offline status</p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Required data:</strong> <code>status</code> (online or offline)</p>
                    <p><strong>Response:</strong> Success or error message.</p>
                    <span class="badge">POST</span>
                </div>
                <div class="list-group-item">
                    <h5><strong>14) check_availability.php</strong></h5>
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