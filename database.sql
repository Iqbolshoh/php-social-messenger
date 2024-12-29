DROP DATABASE IF EXISTS social_chat;

CREATE DATABASE IF NOT EXISTS social_chat;

USE social_chat;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(30) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS block (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blocked_by INT NOT NULL,
    blocked_user INT NOT NULL,
    FOREIGN KEY (blocked_by) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (blocked_user) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE (blocked_by, blocked_user)
);

CREATE TABLE IF NOT EXISTS private_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO
    `users` (
        `full_name`,
        `email`,
        `username`,
        `password`,
        `profile_picture`
    )
VALUES
    (
        'Iqbolshoh Ilhomjonov',
        'iilhomjonov777@gmail.com',
        'iqbolshoh',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        '7261b37e4658f361ec3585b582455f74.jpg'
    ),
    (
        'User One',
        'user1@example.com',
        'user1',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    ),
    (
        'User Two',
        'user2@example.com',
        'user2',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    ),
    (
        'User Three',
        'user3@example.com',
        'user3',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    ),
    (
        'User Four',
        'user4@example.com',
        'user4',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    ),
    (
        'User Five',
        'user5@example.com',
        'user5',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    ),
    (
        'User Six',
        'user6@example.com',
        'user6',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    ),
    (
        'User Seven',
        'user7@example.com',
        'user7',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8',
        'default.png'
    );

INSERT INTO private_messages (sender_id, receiver_id, content)
VALUES
    (2, 1, "Hello!"),
    (2, 1, "Iqbolshoh, how are you?"),
    (2, 1, "Can you help me with creating a website?"),
    (1, 2, "Hello! Of course, what kind of website do you need? Is it for your business or a personal blog?"),
    (2, 1, "I need a website for my business. I want to open an online store."),
    (1, 2, "Great! There are many possibilities for an online store. What kind of products will you be selling?"),
    (2, 1, "I will be selling clothing. A variety of items, including men's, women's, and children's clothing."),
    (1, 2, "Nice! What design and features do you want for the site?"),
    (2, 1, "I prefer a minimalist design. The site should have a homepage, store, promotions, and product categories."),
    (1, 2, "Got it. We also need to add payment systems and delivery functions to the site."),
    (2, 1, "Yes, payment systems and delivery options are necessary. I also need to add pricing and promotions for the products."),
    (1, 2, "What other features would you like to add? Would you need filters or a search system?"),
    (2, 1, "Filters and a search system are very important. We need to filter products by type, price, and brand."),
    (1, 2, "Great. Can you provide more details about the design? What about the colors and the overall look?"),
    (2, 1, "The colors should be in muted tones, mostly white, black, and gray. It should be simple and easy to read."),
    (1, 2, "Understood. Would you like to apply your personal branding to the site? For example, a logo or brand colors?"),
    (2, 1, "Yes, definitely. A logo and brand colors are needed to create the identity of my business."),
    (1, 2, "Great! What other pages do you need? A contact page or customer reviews page?"),
    (2, 1, "Yes, I need a contact page and a customer reviews page. It will make the site more trustworthy."),
    (1, 2, "Do you need login and registration pages?"),
    (2, 1, "Yes, of course. Users should be able to create accounts and track their orders."),
    (1, 2, "One more question: Would you like to make the site mobile-responsive?"),
    (2, 1, "Yes, the site must be mobile-friendly. A lot of users access websites from their phones."),
    (1, 2, "Great! How much time do you need to create the site?"),
    (2, 1, "I need to create the site as soon as possible. How long does it usually take?"),
    (1, 2, "If we are only creating the homepage and the store, it will take 2-3 weeks, but with all additional features, it could take a month."),
    (2, 1, "Got it, that's good. How do you price your services?"),
    (1, 2, "Our services are high quality, and our prices are competitive. We offer great value for the service we provide."),
    (2, 1, "How do you set the prices?"),
    (1, 2, "The prices vary depending on the complexity of the project. Standard packages start from $500, but prices can change for special requirements."),
    (2, 1, "How can I make the payment?"),
    (1, 2, "You can make the payment through bank transfer, PayPal, or Stripe."),
    (2, 1, "Great. What services are currently offered?"),
    (1, 2, "We are continuously improving our services. We offer website creation, SEO, marketing, and additional services as well."),
    (2, 1, "Thanks for introducing your services. If I have more questions, I’ll definitely reach out."),
    (1, 2, "Of course, feel free to contact us with any questions. We are always ready to help."),
    (2, 1, "Thanks! I look forward to working with you."),
    (1, 2, "I’ll be waiting! If you need anything else, you can contact us."),
    (2, 1, "Thanks, I’ll get back to you soon."),
    (1, 2, "I’ll be waiting. Let me know if you need anything."),
    (2, 1, "We should consider all the possibilities when creating the site. Can we discuss good strategies and marketing techniques?"),
    (1, 2, "Of course! Marketing is very important for an online store. We can boost it through SEO and social media."),
    (2, 1, "I’d like to learn more about SEO. How can we get the site ranked higher?"),
    (1, 2, "To optimize the site for SEO, it’s important to choose the right content, improve the speed, and adjust button texts."),
    (2, 1, "Okay, what should we focus on in terms of content? How should we write product descriptions?"),
    (1, 2, "Product descriptions should be engaging and clear. We need to understand user needs and create good content."),
    (2, 1, "What about other marketing techniques? Do you recommend specific social media ads?"),
    (1, 2, "Targeted ads on social media are very effective. You can reach the right audience and create engaging visual content."),
    (2, 1, "I’d like to learn more about targeted ads. How does that work?"),
    (1, 2, "Targeted ads are shown based on users’ interests, age group, and location. This ensures maximum effectiveness."),
    (2, 1, "That’s very interesting. So we only target our audience, right?"),
    (1, 2, "Exactly. This helps save the advertising budget."),
    (2, 1, "Thank you for all the useful advice. Which platform would you recommend for creating the site?"),
    (1, 2, "If you want to create a simple site, WordPress or Shopify are great options. For more custom needs, you can use Laravel or Node.js."),
    (2, 1, "That’s right, I prefer Laravel. It’s very powerful and flexible."),
    (1, 2, "Yes, Laravel is a very strong framework. It will be an ideal choice for you!"),
    (2, 1, "I really appreciate your help. I might have more questions later."),
    (1, 2, "Of course, I’m always ready to help. I look forward to you continuing to use my services."),
    (1, 2, "If you have any more questions or need assistance, feel free to contact me anytime. I'm always ready to help. You can reach me through the following channels:\n\nInstagram: @iqbolshoh_777\nTelegram: @iqbolshoh_777\nX: @iqbolshoh_777\nTikTok: @iqbolshoh_777\nYouTube: @iqbolshoh_777\nEmail: iilhomjonov777@gmail.com\nWebsite: iqbolshoh.uz")

