# PHP Social Messenger

PHP Social Messenger is a real-time messaging application that allows users to chat with each other, edit their profiles, and manage contacts. It provides an easy-to-use interface for sending and receiving messages, managing user profiles, and handling blocked users. The app is built using PHP, MySQL, and JavaScript (AJAX), with a focus on real-time interactions. This application also includes a RESTful API for seamless integration with other services.

## Features

### 1. Real-Time Messaging
   - Instant message updates: Messages are instantly displayed when received. The chat automatically refreshes every few seconds.
   - Message status: Shows which user sent the last message and the number of unread messages.
   - Delete or copy own messages: Users can edit, delete, or copy their own messages, but they cannot edit messages from other users.
 
   ![Real-Time Messaging](./src/images/real_time.png)

### 2. Profile Management
   - Profile Editing: Users can update their profile picture, full name, and password directly from the user interface.
   - View Profile: Clicking on the "View Profile" option lets users see the profile information of the person they are chatting with.

   ![Profile Management](./src/images/profile-management.png)

### 3. Contact Search
   - Search Contacts: Users can search for contacts using the search bar on the homepage (index.php). It dynamically filters the contacts list based on the search term.
   - Manage Contacts: The app displays all the contacts on the main page, including unread messages, allowing users to stay updated.

   ![Contact Search](./src/images/contact-search.png)

### 4. Block Users
   - Block Functionality: Users can block others from sending messages. If you block someone, they will not be able to send you messages anymore, and you will not be able to message them.
   - Blocked Notifications: If a user tries to message someone who has blocked them, they will be notified that they are blocked.
   - Block Menu: The block option is easily accessible via the action menu in the chat interface.

   ![Block Users](./src/images/block-users.png)

### 5. Chat Interface
   - Message History: When entering a chat (chat.php), the complete message history with the other user is shown.
   - Message Actions: Users can delete or copy their own messages, while messages from others cannot be edited.
   - Real-Time Syncing: The chat updates in real-time, ensuring the user always sees the most recent messages.

   ![Chat Interface](./src/images/chat-interface.png)

### 6. Menu Options
   - View Profile: View the profile of the person you’re chatting with.
   - Clear Chat: Clear the entire chat history with a specific user.
   - Block User: Block the user to prevent them from sending you any more messages.

   ![Menu Options](./src/images/menu-options.png)

---

## API

The application also exposes a RESTful API for integrating the messaging functionality into other systems. The API includes endpoints for:

 - Fetching profiles
 - Fetching messages
 - Fetching contacts
 - Sending messages
 - Editing messages
 - Deleting users
 - Managing user accounts

API documentation is available in the docs/ directory. It provides all the necessary details for interacting with the APIs and using them in your own applications.

### Technologies Used

<div style="display: flex; flex-wrap: wrap; gap: 5px;">
    <img src="https://img.shields.io/badge/HTML-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white" alt="HTML">
    <img src="https://img.shields.io/badge/CSS-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white" alt="CSS">
    <img src="https://img.shields.io/badge/Bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
    <img src="https://img.shields.io/badge/JavaScript-%23F7DF1C.svg?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
    <img src="https://img.shields.io/badge/jQuery-%230e76a8.svg?style=for-the-badge&logo=jquery&logoColor=white" alt="jQuery">
    <img src="https://img.shields.io/badge/PHP-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</div>

### Installation

To get started with the PHP-MySQL Marketplace, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/Iqbolshoh/php-social-messenger.git
   ```

2. **Navigate to the Project Directory:**
   ```bash
   cd php-social-messenger
   ```

3. **Set Up the Database:**
   - Create a new MySQL database:
     ```sql
     CREATE DATABASE social_messenger;
     ```

   - Import the `database.sql` file located in the `db` directory:
     ```bash
     mysql -u yourusername -p social_messenger < db/database.sql
     ```

4. **Configure Database Connection:**
   - Open the `config.php` file in the root directory.
   - Update the database credentials:
     ```php
     define("DB_SERVER", "localhost");
     define("DB_USERNAME", "root");
     define("DB_PASSWORD", "");
     define("DB_NAME", "social_messenger");
     ```

5. **Run the Application:**
   - Deploy the application on a PHP-compatible server (e.g., Apache or Nginx).
   - Access the application through your browser at `http://localhost/php-social-messenger`.

## Contributing

Contributions are welcome! If you have suggestions or want to enhance the project, feel free to fork the repository and submit a pull request.


## Connect with Me

I love connecting with new people and exploring new opportunities. Feel free to reach out to me through any of the platforms below:

<table>
    <tr>
        <td>
            <a href="https://github.com/iqbolshoh">
                <img src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/github.svg"
                    height="48" width="48" alt="GitHub" />
            </a>
        </td>
        <td>
            <a href="https://t.me/iqbolshoh_777">
                <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/telegram.svg"
                    height="48" width="48" alt="Telegram" />
            </a>
        </td>
        <td>
            <a href="https://www.linkedin.com/in/iiqbolshoh/">
                <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/linkedin.svg"
                    height="48" width="48" alt="LinkedIn" />
            </a>
        </td>
        <td>
            <a href="https://instagram.com/iqbolshoh_777" target="blank"><img align="center"
                    src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/instagram.svg"
                    alt="instagram" height="48" width="48" /></a>
        </td>
        <td>
            <a href="https://wa.me/qr/22PVFQSMQQX4F1">
                <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/whatsapp.svg"
                    height="48" width="48" alt="WhatsApp" />
            </a>
        </td>
        <td>
            <a href="https://x.com/iqbolshoh_777">
                <img src="https://img.shields.io/badge/X-000000?style=for-the-badge&logo=x&logoColor=white" height="48"
                    width="48" alt="Twitter" />
            </a>
        </td>
        <td>
            <a href="mailto:iilhomjonov777@gmail.com">
                <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/gmail.svg"
                    height="48" width="48" alt="Email" />
            </a>
        </td>
    </tr>
</table>

