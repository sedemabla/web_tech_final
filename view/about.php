<?php
session_start(); // Start session for user login management or flash messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fur & Friends</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');

        :root {
            --dark-blue: #3E3C6E;
            --pink: #FE979B;
            --peach: #FEAE97;
            --light-pink: #F6E8DF;
            --cream: #F6E8DF;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-pink);
        }

        header {
            background-color: var(--dark-blue);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            font-family: 'Fredoka One', cursive;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            background-color: var(--pink);
            color: white;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: var(--peach);
        }

        .hero-section {
            background: linear-gradient(135deg, #FEAE97, #FE979B);
            padding: 3rem;
            text-align: center;
            color: white;
            margin-bottom: 2rem;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-family: 'Fredoka One', cursive;
        }

        .hero-section p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .about-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 800px;
        }

        .about-section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark-blue);
            font-family: 'Fredoka One', cursive;
            text-align: center;
        }

        .about-section p {
            font-size: 1rem;
            line-height: 1.6;
            color: #3E3C6E;
            text-align: justify;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .feature-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--pink);
        }

        .feature-card h3 {
            color: var(--dark-blue);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 1rem;
            color: #3E3C6E;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: var(--dark-blue);
            color: white;
            margin-top: 2rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1.2rem;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Fur & Friends</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="contact.php">Contact</a>
            <a href="about.php">About Us</a>
            <a href="signup.php">Sign Up</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1>About Us</h1>
        <p>At Fur & Friends, we are passionate about creating a world where pets and their owners thrive together. Learn more about what we do!</p>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <h2>Who We Are</h2>
        <p>Fur & Friends is a platform dedicated to providing pet owners with valuable insights, tips, and DIY ideas for training and caring for their beloved furry companions. Whether you're looking for expert advice on behavioral training, creative ways to engage your pets, or health tips to ensure their well-being, we’ve got you covered.</p>
    </section>

    <!-- Features Section -->
    <section class="about-section">
        <h2>What We Offer</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <i class='bx bx-dog'></i>
                <h3>Training Tips</h3>
                <p>Explore effective training techniques to build a stronger bond with your pets.</p>
            </div>
            <div class="feature-card">
                <i class='bx bx-paint'></i>
                <h3>DIY Projects</h3>
                <p>Create fun toys and treats to keep your pets happy and engaged.</p>
            </div>
            <div class="feature-card">
                <i class='bx bx-heart'></i>
                <h3>Health Advice</h3>
                <p>Access expert health tips to keep your furry friends in great shape.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="about-section">
        <h2>Join Our Community</h2>
        <p>Become part of a growing community of pet lovers. Share your experiences, learn from others, and make every day a special one for you and your pets!</p>
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
