<?php
session_start(); // Start session for user login management
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Fur & Friends</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');

        :root {
            --dark-blue: #3E3C6E;
            --pink: #FE979B;
            --peach: #FEAE97;
            --light-pink: #F6E8DF;
            --cream: #F6E8DF;
            --white: #FFFFFF;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream);
        }

        header {
            background-color: var(--dark-blue);
            color: white;
            text-align: center;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-family: 'Fredoka One', cursive;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: var(--pink);
            padding: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }

        nav a:hover {
            color: var(--dark-blue);
        }

        .hero {
            position: relative;
            text-align: center;
            color: white;
        }

        .hero img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            filter: brightness(70%);
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hero-text h2 {
            font-size: 3rem;
            font-family: 'Fredoka One', cursive;
            margin: 0;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-top: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .contact-section {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap;
            padding: 50px 20px;
            background-color: var(--cream);
        }

        .contact-card {
            flex: 1 1 45%;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            max-width: 500px;
        }

        .contact-card .bx {
            font-size: 50px;
            margin-bottom: 10px;
            color: var(--pink);
        }

        .contact-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-family: 'Fredoka One', cursive;
            color: var(--dark-blue);
        }

        .contact-card p {
            font-size: 1rem;
            margin-bottom: 15px;
            color: var(--dark-blue);
        }

        .contact-card a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background-color: var(--pink);
            color: white;
            font-weight: bold;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .contact-card a:hover {
            background-color: var(--dark-blue);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: var(--dark-blue);
            color: white;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Fur & Friends</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="actions/logout.php">Logout</a>
        <?php else: ?>
            <a href="signup.php">Sign Up</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>

    <!-- Hero Section with a Big Image -->
    <section class="hero">
        <img src="assets/contact.jpg" alt="Get in Touch Image">
        <div class="hero-text">
            <h2>Get in Touch</h2>
            <p>Want to get in touch? We’d love to hear from you. Here’s how you can reach us.</p>
        </div>
    </section>

    <!-- Contact Cards Section -->
    <section class="contact-section">
        <!-- Card 1 -->
        <div class="contact-card">
            <i class='bx bxs-phone'></i> <!-- Boxicon for Phone -->
            <h3>Talk to Sales</h3>
            <p>
                Want to talk to us? Just pick up the phone to chat with a member of our team.
            </p>
            <a href="tel:+233592209149">+233592209149</a>
        </div>

        <!-- Card 2 -->
        <div class="contact-card">
            <i class='bx bxs-chat'></i> <!-- Boxicon for Support -->
            <h3>Contact Customer Support</h3>
            <p>
                Need help? Our support team is here to assist you with any questions you may have.
            </p>
            <a href="mailto:support@furandfriends.com">Contact Support</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Fur & Friends. All rights reserved.</p>
        <div class="footer-links">
            <a href="https://www.instagram.com" target="_blank">Instagram</a>
            <a href="https://www.twitter.com" target="_blank">Twitter</a>
            <a href="https://www.snapchat.com" target="_blank">Snapchat</a>
        </div>
    </footer>
</body>
</html>
