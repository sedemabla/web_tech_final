<?php
session_start(); // Start session for managing user authentication
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fur & Friends</title>
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

        header p {
            margin: 5px 0 0;
            font-size: 1.2rem;
        }

        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .auth-buttons button {
            background-color: var(--pink);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .auth-buttons button:hover {
            background-color: var(--peach);
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            background-color: var(--peach);
        }

        .hero img {
            width: 600px;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
        }

        .hero-text {
            max-width: 50%;
            color: var(--dark-blue);
        }

        .hero-text h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-family: 'Fredoka One', cursive;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .hero-text button {
            background-color: var(--pink);
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .hero-text button:hover {
            background-color: var(--dark-blue);
        }

        .features {
            display: flex;
            justify-content: space-around;
            padding: 50px;
            background-color: var(--light-pink);
        }

        .feature-card {
            text-align: center;
            max-width: 200px;
            color: var(--dark-blue);
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feature-card img {
            max-width: 80px;
            margin-bottom: 10px;
            border-radius: 50%;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: var(--dark-blue);
            color: white;
        }

        .social-links a {
            margin: 0 10px;
            font-size: 1.2rem;
            color: white;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-links a:hover {
            color: var(--pink);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="auth-buttons">
            <button onclick="location.href='view/login.php'">Login</button>
            <button onclick="location.href='view/signup.php'">Sign Up</button>
        </div>
        <?php else: ?>
        <div class="auth-buttons">
            <button onclick="location.href='actions/logout.php'">Logout</button>
        </div>
        <?php endif; ?>
        <h1>Fur & Friends</h1>
        <p>Your ultimate guide for pet training and care!</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="view/training_tips.php">Tips & Training</a>
        <a href="view/diy_ideas.php">DIY Ideas</a>
        <a href="view/health_tips.php">Health Tips</a>
        <a href="view/about.php">About Us</a>
        <a href="view/contact.php">Contact</a>
    </nav>

    <div class="hero">
        <div class="hero-text">
            <h1>Welcome to Fur & Friends!</h1>
            <p>Discover the best pet training techniques, care tips, and creative DIY ideas tailored for your furry friends. Join our community today!</p>
            <button onclick="location.href='view/signup.php'">Get Started</button>
        </div>
        <img id="dynamicImage" src="/assets/dogpicture1.jpg" alt="Happy pet">
    </div>

    <script>
        const images = [
            "assets/dogpicture2.jpg",
            "assets/dogpicture1.jpg",
            "assets/dogpicture3.jpg",
            "assets/dogpicture4.jpg",
            "assets/dogpicture5.jpg",
        ];
        let currentIndex = 0;

        function changeImage() {
            currentIndex = (currentIndex + 1) % images.length; // Cycle through all images
            document.getElementById("dynamicImage").src = images[currentIndex];
        }

        // Set first image immediately and cycle every 3 seconds
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("dynamicImage").src = images[0];
            setInterval(changeImage, 3000);
        });
    </script>

    <section class="features">
        <div class="feature-card">
            <img src="assets/trainingtipspic.jpg" alt="Training">
            <h3>Training Tips</h3>
            <p>Learn effective training techniques for your pets.</p>
        </div>
        <div class="feature-card">
            <img src="assets/diypic.jpg" alt="DIY">
            <h3>DIY Projects</h3>
            <p>Creative recipes and toy ideas for your pets.</p>
        </div>
        <div class="feature-card">
            <img src="assets/healthtipspic.jpg" alt="Health">
            <h3>Health Tips</h3>
            <p>Keep your pets healthy and happy with expert advice.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Fur & Friends. All rights reserved.</p>
        <div class="social-links">
            <a href="https://www.instagram.com" target="_blank">Instagram</a>
            <a href="https://www.twitter.com" target="_blank">Twitter</a>
            <a href="https://www.snapchat.com" target="_blank">Snapchat</a>
        </div>
    </footer>
</body>
</html>
