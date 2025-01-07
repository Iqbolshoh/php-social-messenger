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
                            <li><strong><code>username</code></strong>: The username of the user (a string). For example, <code>iqbolshoh</code> or <code>clientuser</code>.</li>
                            <li><strong><code>password</code></strong>: The password of the user (a string). For example, <code>mypassword123</code>.</li>
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

username=iqbolshoh&password=yourpassword123
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
        "full_name": "Iqbolshoh Ilhomjonov",
        "email": "iilhomjonov777@gmail.com",
        "username": "iqbolshoh",
        "profile_picture": "src/images/profile-picture/iqbolshoh.jpg"
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
                            <li><strong><code>username</code></strong>: The desired username for the new user (a string). For example, <code>iqbolshoh</code> or <code>clientuser</code>.</li>
                            <li><strong><code>email</code></strong>: The user's email address (a string). For example, <code>iilhomjonov777@gmail.com</code> or <code>clientuser@example.com</code>.</li>
                            <li><strong><code>password</code></strong>: The password the user chooses (a string). For example, <code>password123</code>.</li>
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

username=iqbolshoh&email=iilhomjonov777@gmail.com&password=password123&confirm_password=password123
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
        "full_name": "Iqbolshoh Ilhomjonov",
        "email": "iilhomjonov777@gmail.com",
        "username": "iqbolshoh",
        "profile_picture": "src/images/profile-picture/iqbolshoh.jpg"
    }
}
        </pre>
                        </code>

                        <p><strong>Notes:</strong> After a successful registration, the user is automatically logged in, and a session is created. Two cookies are also set: <code>username</code> and <code>session_token</code> for persistent login across sessions.</p>

                        <span class="badge bg-primary">POST</span>
                    </div>

                    <div class="list-group-item">
                        <h5><strong>4) check_login.php</strong></h5>
                        <p><strong>Purpose:</strong> Checks if the user is logged in. This API verifies whether the user is currently logged into the system. If the user is logged in, it returns the user's details. If not, it will return a message stating that the user is not logged in.</p>

                        <p><strong>Method:</strong> <code>SESSION</code></p>

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
SESSION /api/auth/check_login.php HTTP/1.1
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
        "full_name": "Iqbolshoh Ilhomjonov",
        "email": "iilhomjonov777@gmail.com",
        "username": "iqbolshoh",
        "profile_picture": "src/images/profile-picture/iqbolshoh.jpg"
    }
}
        </pre>
                        </code>

                        <p><strong>Notes:</strong> If the user is logged in, their session information will be returned as part of the response. If the user is not logged in, the response will indicate that the user is not logged in.</p>

                        <span class="badge bg-primary">SESSION</span>
                    </div>

                    <div class="list-group-item">
                        <h5><strong>5) check_availability.php</strong></h5>
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

email=iilhomjonov777@gmail.com
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
                    <h5><strong>6) send_message.php</strong></h5>
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
POST /api/messages/send_message.php HTTP/1.1
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
                    <p><strong>Purpose:</strong> Retrieves all messages for the logged-in user. This API allows the logged-in user to fetch all messages exchanged with another user. The messages are ordered by creation date.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required Data:</strong>
                    <ul>
                        <li><strong><code>id (receiver_id)</code></strong>: The ID of the user whose messages are being retrieved. This should be the user with whom the logged-in user has exchanged messages.</li>
                    </ul>
                    </p>

                    <p><strong>Response:</strong> The API returns a JSON response with a list of messages exchanged between the logged-in user and the receiver.</p>

                    <ul>
                        <li><strong>If Messages Are Found:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> Messages fetched successfully</li>
                                <li><strong>Data:</strong> JSON array of message objects containing message details (sender_id, receiver_id, content, created_at, status).</li>
                            </ul>
                        </li>
                        <li><strong>If No Messages Are Found:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> No messages found</li>
                            </ul>
                        </li>
                        <li><strong>If Receiver ID is Missing:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> Receiver ID is required</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/messages/fetch_messages.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

id=2
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "Messages fetched successfully",
    "data": [
        {
            "id": 1,
            "sender_id": 1,
            "receiver_id": 2,
            "content": "Hello, how are you?",
            "created_at": "2025-01-06 14:00:00",
            "status": "read"
        },
        {
            "id": 2,
            "sender_id": 2,
            "receiver_id": 1,
            "content": "I'm good, thank you!",
            "created_at": "2025-01-06 14:05:00",
            "status": "read"
        }
    ]
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>If the user is not logged in, the API will return an error indicating that the user is not logged in.</li>
                        <li>The response will include all messages exchanged between the logged-in user and the specified receiver, ordered by creation date.</li>
                        <li>If no messages are found, the API will return an error message stating "No messages found".</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
                </div>

                <div class="list-group-item">
                    <h5><strong>7) delete_message.php</strong></h5>
                    <p><strong>Purpose:</strong> Deletes a specific message. This API allows the logged-in user to delete a message by providing its ID. The system will check if the message exists and if the user is authorized to delete it.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required Data:</strong>
                    <ul>
                        <li><strong><code>message_id</code></strong>: The ID of the message to be deleted.</li>
                    </ul>
                    </p>

                    <p><strong>Response:</strong> The API returns a JSON response indicating whether the deletion was successful or if there was an error.</p>

                    <ul>
                        <li><strong>If Message is Deleted Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> Message deleted successfully</li>
                            </ul>
                        </li>
                        <li><strong>If Message is Not Found:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> Message not found</li>
                            </ul>
                        </li>
                        <li><strong>If Deletion Fails:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> Failed to delete the message. Please try again later</li>
                            </ul>
                        </li>
                        <li><strong>If Message ID is Missing:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> Message ID is required</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/messages/delete_message.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

message_id=5
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "Message deleted successfully"
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>Ensure that the provided <code>message_id</code> exists in the system before attempting to delete it.</li>
                        <li>The deletion is only possible if the logged-in user has the appropriate rights (i.e., the user is the sender or the receiver of the message).</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
                </div>

                <div class="list-group-item">
                    <h5><strong>8) edit_message.php</strong></h5>
                    <p><strong>Purpose:</strong> Edits an existing message. This API allows the logged-in user to edit their previously sent message by providing the message ID and the new content. The system ensures that only the sender of the message can edit it.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required Data:</strong>
                    <ul>
                        <li><strong><code>message_id</code></strong>: The ID of the message to be edited.</li>
                        <li><strong><code>new_message_content</code></strong>: The new content to replace the original message content.</li>
                    </ul>
                    </p>

                    <p><strong>Response:</strong> The API returns a JSON response indicating whether the edit operation was successful or if there was an error.</p>

                    <ul>
                        <li><strong>If Message is Edited Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> Message updated successfully</li>
                            </ul>
                        </li>
                        <li><strong>If Message is Not Found or Unauthorized Edit Attempt:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> Message not found or you do not have permission to edit this message</li>
                            </ul>
                        </li>
                        <li><strong>If Content is Empty:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> Message content cannot be empty</li>
                            </ul>
                        </li>
                        <li><strong>If Required Parameters are Missing:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> Invalid request or missing parameters</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/messages/edit_message.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

message_id=3&new_message_content=Updated%20message%20content
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "Message updated successfully"
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>The sender of the message is the only one allowed to edit it.</li>
                        <li>If the message content is empty, it cannot be saved.</li>
                        <li>If the user tries to edit a message they did not send, they will receive an error response.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
                </div>

                <div class="list-group-item">
                    <h5><strong>9) clear_messages.php</strong></h5>
                    <p><strong>Purpose:</strong> Clears all messages for the logged-in user. This API allows the logged-in user to delete all their messages exchanged with a specific user. Once the request is made, the system deletes all messages between the logged-in user and the specified receiver.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required Data:</strong>
                    <ul>
                        <li><strong><code>clear</code></strong>: This must be set to <code>true</code> to confirm that the user wants to clear the messages.</li>
                        <li><strong><code>receiver_id</code></strong>: The ID of the user whose messages with the logged-in user are to be deleted.</li>
                    </ul>
                    </p>

                    <p><strong>Response:</strong> The API returns a JSON response indicating whether the deletion was successful or if there was an error.</p>

                    <ul>
                        <li><strong>If Messages are Deleted Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> All messages successfully deleted.</li>
                            </ul>
                        </li>
                        <li><strong>If No Messages are Found or an Error Occurred:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> No messages found to delete or an error occurred.</li>
                            </ul>
                        </li>
                        <li><strong>If Parameters are Missing or Invalid:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> Invalid request. Please provide necessary parameters.</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/messages/clear_messages.php HTTP/1.1
Content-Type: application/x-www-form-urlencoded

clear=true&receiver_id=4
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "All messages successfully deleted."
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>Both the logged-in user and the receiver's messages will be deleted.</li>
                        <li>If there are no messages between the logged-in user and the receiver, an error will be returned.</li>
                        <li>It is important to ensure that the <code>clear</code> parameter is set to <code>true</code> to confirm the action.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
                </div>

            </div>
        </section>

        <section>
            <h2>Other Helper APIs</h2>
            <div class="list-group">
                <div class="list-group-item">
                    <h5><strong>10) fetch_contacts.php</strong></h5>
                    <p><strong>Purpose:</strong> Retrieves the list of contacts for the logged-in user. This API allows the logged-in user to fetch a list of all their contacts. The list includes details like the user's full name, username, profile picture, and the time of the last message exchanged with the user. If there are any unread messages, the number of unread messages will also be included for each contact.</p>

                    <p><strong>Method:</strong> <code>GET</code></p>

                    <p><strong>Response:</strong> The API returns a JSON response containing the list of contacts, along with information about each contact, such as unread messages and the time of the last message.</p>

                    <ul>
                        <li><strong>If Contacts are Retrieved Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> Contacts retrieved successfully.</li>
                                <li><strong>Data:</strong> A list of contacts, with each contact containing the following details:
                                    <ul>
                                        <li><strong>user_id</strong>: The unique ID of the contact</li>
                                        <li><strong>full_name</strong>: The full name of the contact</li>
                                        <li><strong>username</strong>: The username of the contact</li>
                                        <li><strong>profile_picture</strong>: The profile picture URL of the contact</li>
                                        <li><strong>last_message_time</strong>: The time of the last message exchanged with the contact</li>
                                        <li><strong>unread_messages</strong>: The count of unread messages from the logged-in user to the contact</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><strong>If No Contacts are Found:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> No contacts found.</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
GET /api/fetch_contacts.php HTTP/1.1
Content-Type: application/json
        </pre>
                    </code>
                    <p><strong>Optional Search:</strong> You can optionally include a search term to filter contacts by full name or username using the <code>search</code> query parameter. Example:</p>
                    <code>
                        <pre>
GET /api/fetch_contacts.php?search=iqbolshoh HTTP/1.1
Content-Type: application/json
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "Contacts retrieved successfully",
    "data": [
        {
            "user_id": 2,
            "full_name": "Jane Doe",
            "username": "janedoe",
            "profile_picture": "src/images/profile-picture/janedoe.jpg",
            "last_message_time": "2025-01-05 15:30:00",
            "unread_messages": 3
        },
        {
            "user_id": 3,
            "full_name": "Iqbolshoh Ilhomjonov",
            "username": "iqbolshoh",
            "profile_picture": "src/images/profile-picture/iqbolshoh.jpg",
            "last_message_time": "2025-01-04 12:45:00",
            "unread_messages": 1
        }
    ]
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>If no contacts are found, an error message will be returned.</li>
                        <li>The response includes the number of unread messages for each contact.</li>
                        <li>The <code>search</code> query parameter can be used to filter contacts based on their full name or username.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">GET</span>
                </div>

                <div class="list-group-item">
                    <h5><strong>11) fetch_profile.php</strong></h5>
                    <p><strong>Purpose:</strong> Retrieves the user's profile information. This API endpoint is used to fetch the profile details of the logged-in user. It provides the user's full name, username, profile picture, and other profile-related data.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Response:</strong> The response contains a JSON object with the user's profile information. This includes the user's full name, username, profile picture, and other related data.</p>

                    <ul>
                        <li><strong>If Profile is Retrieved Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> Profile data retrieved successfully.</li>
                                <li><strong>Data:</strong> A JSON object containing the user's profile details:
                                    <ul>
                                        <li><strong>user_id</strong>: The unique ID of the user</li>
                                        <li><strong>full_name</strong>: The full name of the user</li>
                                        <li><strong>username</strong>: The username of the user</li>
                                        <li><strong>profile_picture</strong>: The URL or path to the user's profile picture</li>
                                        <li><strong>last_message_time</strong>: The time of the last message exchanged with the user (if applicable)</li>
                                        <li><strong>unread_messages</strong>: The count of unread messages (if applicable)</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><strong>If No Profile Found or Error Occurs:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> User is not logged in or an error occurred retrieving the profile.</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/fetch_profile.php HTTP/1.1
Content-Type: application/json
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "Profile data retrieved successfully",
    "data": {
        "user_id": 1,
        "full_name": "Iqbolshoh Ilhomjonov",
        "username": "iqbolshoh",
        "profile_picture": "src/images/profile-picture/iqbolshoh.jpg",
        "last_message_time": "2025-01-05 14:20:00",
        "unread_messages": 2
    }
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>This API is specifically for retrieving the profile data of the logged-in user. If the user is not logged in, an error response will be returned.</li>
                        <li>The response will include the user's ID, full name, username, profile picture URL, and additional information like the time of the last message and the number of unread messages.</li>
                        <li>In case the user is not logged in or an error occurs during the profile retrieval, the API will return an appropriate error message.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
                </div>

                <div class="list-group-item">
                    <h5><strong>12) change_user_status.php</strong></h5>
                    <p><strong>Purpose:</strong> Changes the user's status between block and unblock. This API endpoint allows a logged-in user to either block or unblock another user.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required data:</strong> The request must include two parameters:
                    <ul>
                        <li><strong><code>user_id</code></strong>: The ID of the user to be blocked or unblocked.</li>
                        <li><strong><code>action</code></strong>: The action to be performed, either <code>block</code> or <code>unblock</code>.</li>
                    </ul>
                    </p>

                    <p><strong>Response:</strong> A JSON response with a success or error message, based on the action taken.</p>

                    <ul>
                        <li><strong>If Status is Changed Successfully:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">success</span></li>
                                <li><strong>Message:</strong> The user's status was successfully updated.</li>
                            </ul>
                        </li>
                        <li><strong>If No Valid Action is Provided:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">error</span></li>
                                <li><strong>Message:</strong> "Invalid action. Please provide either 'block' or 'unblock' action."</li>
                            </ul>
                        </li>
                        <li><strong>If User is Blocked:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">blocked</span></li>
                                <li><strong>Message:</strong> "You are blocked by this user."</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/change_user_status.php HTTP/1.1
Content-Type: application/json
{
    "user_id": 2,
    "action": "block"
}
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "success",
    "message": "User has been blocked successfully."
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>This API allows the logged-in user to change another user's status to either "blocked" or "unblocked".</li>
                        <li>If the user tries to block an already blocked user or unblock an already unblocked user, an error message will be returned.</li>
                        <li>If the user is blocked by the other user, the request will be denied with a "blocked" response.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
                </div>


                <div class="list-group-item">
                    <h5><strong>13) check_user_status.php</strong></h5>
                    <p><strong>Purpose:</strong> Checks the user's online/offline status. This API helps determine if a user is currently online, offline, or blocked by another user.</p>

                    <p><strong>Method:</strong> <code>POST</code></p>

                    <p><strong>Required data:</strong> The request must include a <code>receiver_id</code> (the user whose status you want to check).</p>

                    <p><strong>Response:</strong> A JSON response with information on whether the user is blocked or not.</p>

                    <ul>
                        <li><strong>If User is Not Blocked:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-success">unblocked</span></li>
                                <li><strong>Message:</strong> "You are not blocked by this user."</li>
                            </ul>
                        </li>
                        <li><strong>If User is Blocked:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-danger">blocked</span></li>
                                <li><strong>Message:</strong> "You are blocked by this user."</li>
                            </ul>
                        </li>
                        <li><strong>If Receiver ID is Missing:</strong>
                            <ul>
                                <li><strong>Status:</strong> <span class="badge bg-warning">error</span></li>
                                <li><strong>Message:</strong> "Receiver ID is required. Please provide a valid receiver ID."</li>
                            </ul>
                        </li>
                    </ul>

                    <p><strong>Example Request:</strong></p>
                    <code>
                        <pre>
POST /api/check_user_status.php HTTP/1.1
Content-Type: application/json
{
    "receiver_id": 123
}
        </pre>
                    </code>

                    <p><strong>Example Response:</strong></p>
                    <code>
                        <pre>
{
    "status": "unblocked",
    "message": "You are not blocked by this user."
}
        </pre>
                    </code>

                    <p><strong>Notes:</strong>
                    <ul>
                        <li>This API endpoint allows a user to check if they are blocked by another user by providing the <code>receiver_id</code>.</li>
                        <li>If the user is blocked, the API will return a "blocked" message. If they are not blocked, the API will return an "unblocked" message.</li>
                    </ul>
                    </p>

                    <span class="badge bg-primary">POST</span>
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