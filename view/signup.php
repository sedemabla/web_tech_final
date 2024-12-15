<?php
session_start(); // Start a session to manage flash messages and other session data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Fur & Friends</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #FEAE97 25%, #FE979B 75%);
            background-size: cover;
            position: relative;
            overflow: hidden;
        }

        /* Decorative dynamic bubbles */
        body::before,
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            z-index: 1;
            animation: float 8s infinite ease-in-out;
        }

        body::before {
            top: -100px;
            left: -100px;
        }

        body::after {
            bottom: -150px;
            right: -150px;
            animation-delay: 4s; /* Delays animation for variety */
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-30px) translateX(30px);
            }
            100% {
                transform: translateY(0) translateX(0);
            }
        }

        .signup-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            z-index: 2;
            position: relative;
        }

        .signup-container h1 {
            text-align: center;
            color: #3E3C6E;
            font-family: 'Fredoka One', cursive;
        }

        .signup-container form {
            display: flex;
            flex-direction: column;
        }

        .signup-container input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .signup-container button {
            background-color: #FE979B;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .signup-container button:hover {
            background-color: #3E3C6E;
        }

        .signup-container a {
            text-align: center;
            display: block;
            margin-top: 10px;
            color: #3E3C6E;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .error, .success {
            font-size: 0.9rem;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .error {
            color: #ff0000;
            background: #fdd;
        }

        .success {
            color: #006400;
            background: #dfd;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Signup</h1>

        <!-- Display error or success messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="../actions/signup_user.php" method="POST">
            <input type="text" id="firstName" name="first_name" placeholder="First Name" required>
            <input type="text" id="lastName" name="last_name" placeholder="Surname" required>
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Signup</button>
        </form>
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>
</html>
