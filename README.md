# 💬 PHP Social Messenger 

**PHP Social Messenger** is a **real-time messaging** application that allows users to **chat with each other**, **edit profiles**, and **manage contacts**. It offers a user-friendly interface for sending & receiving messages, handling blocked users, and managing profiles. Built with **PHP, MySQL, and JavaScript (AJAX)**, it ensures smooth real-time interactions. The app also includes a **RESTful API** for seamless integration with other services.  

## ✨ Features  

### 1️⃣ Real-Time Messaging ⚡  
✅ **Instant updates:** Messages appear instantly without refreshing.  
✅ **Message status:** Shows the last sender and unread message count.  
✅ **Message actions:** Users can **edit, delete, or copy** their own messages.  

![Real-Time Messaging](./src/images/real_time.png)  

### 2️⃣ Profile Management 👤  
✅ **Edit profile:** Update your **profile picture, name, and password**.  
✅ **View profile:** See details of the person you are chatting with.  

![Profile Management](./src/images/profile-management.png)  

### 3️⃣ Contact Search 🔍  
✅ **Find contacts easily** using the **dynamic search bar**.  
✅ **Manage contacts** & see unread messages on the homepage.  

![Contact Search](./src/images/contact-search.png)  

### 4️⃣ Block Users 🚫  
✅ **Block people** from sending you messages.  
✅ **Blocked notifications:** Users get alerts if they try to message someone who blocked them.  
✅ **Easily accessible block menu** in the chat interface.  

![Block Users](./src/images/block-users.png)  

### 5️⃣ Chat Interface 💬  
✅ **Full message history** when opening a chat.  
✅ **Delete or copy** your own messages.  
✅ **Real-time syncing** for a smooth messaging experience.  

![Chat Interface](./src/images/chat-interface.png)  

### 6️⃣ Menu Options 🎛️  
✅ **View profile** of the person you’re chatting with.  
✅ **Clear chat** history with a specific user.  
✅ **Block user** to prevent them from messaging you.  

![Menu Options](./src/images/menu-options.png)  

---  

## ⚙️ Installation Guide 🛠️  

Follow these steps to set up **PHP Social Messenger** on your local server:  

### 1️⃣ Clone the Repository 📥  
```bash
git clone https://github.com/Iqbolshoh/php-social-messenger.git
```  

### 2️⃣ Navigate to the Project Directory 📂  
```bash
cd php-social-messenger
```  

### 3️⃣ Set Up the Database 🗄️  
- **Create a new MySQL database:**  
  ```sql
  CREATE DATABASE social_messenger;
  ```  
- **Import the database schema:**  
  ```bash
  mysql -u yourusername -p social_messenger < db/database.sql
  ```  

### 4️⃣ Configure Database Connection ⚡  
- Open **`config.php`** and update your database credentials:  
  ```php
  define("DB_SERVER", "localhost");
  define("DB_USERNAME", "root");
  define("DB_PASSWORD", "");
  define("DB_NAME", "social_messenger");
  ```  

### 5️⃣ Run the Application 🚀  
- Deploy on a **PHP-compatible server** (e.g., Apache, Nginx).  
- Open your browser and go to:  
  **`http://localhost/php-social-messenger`**  


## 🖥 Technologies Used
![HTML](https://img.shields.io/badge/HTML-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-%23F7DF1C.svg?style=for-the-badge&logo=javascript&logoColor=black)
![jQuery](https://img.shields.io/badge/jQuery-%230e76a8.svg?style=for-the-badge&logo=jquery&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)

## 📜 License
This project is open-source and available under the **MIT License**.

## 🤝 Contributing  
🎯 Contributions are welcome! If you have suggestions or want to enhance the project, feel free to fork the repository and submit a pull request.

## 📬 Connect with Me  
💬 I love meeting new people and discussing tech, business, and creative ideas. Let’s connect! You can reach me on these platforms:

<div align="center">
  <table>
    <tr>
      <td>
        <a href="https://iqbolshoh.uz" target="_blank">
          <img src="https://img.icons8.com/color/48/domain.png" 
               height="40" width="40" alt="Website" title="Website" />
        </a>
      </td>
      <td>
        <a href="mailto:iilhomjonov777@gmail.com" target="_blank">
          <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/gmail.svg"
               height="40" width="40" alt="Email" title="Email" />
        </a>
      </td>
      <td>
        <a href="https://github.com/iqbolshoh" target="_blank">
          <img src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/github.svg"
               height="40" width="40" alt="GitHub" title="GitHub" />
        </a>
      </td>
      <td>
        <a href="https://www.linkedin.com/in/iqbolshoh/" target="_blank">
          <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/linkedin.svg"
               height="40" width="40" alt="LinkedIn" title="LinkedIn" />
        </a>
      </td>
      <td>
        <a href="https://t.me/iqbolshoh_777" target="_blank">
          <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/telegram.svg"
               height="40" width="40" alt="Telegram" title="Telegram" />
        </a>
      </td>
      <td>
        <a href="https://wa.me/998997799333" target="_blank">
          <img src="https://github.com/gayanvoice/github-active-users-monitor/blob/master/public/images/icons/whatsapp.svg"
               height="40" width="40" alt="WhatsApp" title="WhatsApp" />
        </a>
      </td>
      <td>
        <a href="https://instagram.com/iqbolshoh_777" target="_blank">
          <img src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/instagram.svg"
               height="40" width="40" alt="Instagram" title="Instagram" />
        </a>
      </td>
      <td>
        <a href="https://x.com/iqbolshoh_777" target="_blank">
          <img src="https://img.shields.io/badge/X-000000?style=for-the-badge&logo=x&logoColor=white"
               height="40" width="40" alt="X" title="X (Twitter)" />
        </a>
      </td>
      <td>
        <a href="https://www.youtube.com/@Iqbolshoh_777" target="_blank">
          <img src="https://raw.githubusercontent.com/rahuldkjain/github-profile-readme-generator/master/src/images/icons/Social/youtube.svg"
               height="40" width="40" alt="YouTube" title="YouTube" />
        </a>
      </td>
    </tr>
  </table>
</div>
