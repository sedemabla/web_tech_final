<?php if (isset($_SESSION['error'])): ?>
    <p class="error" style="display: block;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fur & Friends</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #FE979B, #FEAE97, #F6E8DF, #3E3C6E);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 350px;
            z-index: 2;
        }

        .login-container h1 {
            text-align: center;
            color: #3E3C6E;
            font-family: 'Fredoka One', cursive;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .login-container button {
            background-color: #FE979B;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .login-container button:hover {
            background-color: #3E3C6E;
        }

        .login-container a {
            text-align: center;
            display: block;
            margin-top: 10px;
            color: #3E3C6E;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            display: none;
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script>
        function validateLoginForm() {
            const username = document.getElementById('username');
            const password = document.getElementById('password');
            const error = document.getElementById('error-message');

            if (username.value.trim() === '' || password.value.trim() === '') {
                error.style.display = 'block';
                error.textContent = "All fields are required.";
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="../actions/login_user.php" method="POST" onsubmit="return validateLoginForm();">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <p id="error-message" class="error"></p>
            <button type="submit">Login</button>
        </form>
        <a href="signup.php">Don't have an account? Signup</a>
    </div>
</body>
</html>
