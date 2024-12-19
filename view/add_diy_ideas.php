<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add DIY Idea - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        
        :root {
            --dark-blue: #3E3C6E;
            --pink: #FE979B;
            --peach: #FEAE97;
            --light-pink: #F6E8DF;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--light-pink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-family: 'Fredoka One', cursive;
            margin: 0;
        }

        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: var(--dark-blue);
            font-family: 'Fredoka One', cursive;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-blue);
            font-weight: 600;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: calc(100% - 1.6rem - 4px); /* Adjust for padding and border */
            padding: 0.8rem;
            border: 2px solid var(--light-pink);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease;
            box-sizing: border-box; /* Add this */
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--peach);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-group input[type="file"] {
            width: calc(100% - 1rem); /* Adjust for padding */
            padding: 0.5rem;
            border: 2px dashed var(--peach);
            border-radius: 8px;
            background: var(--light-pink);
            cursor: pointer;
            box-sizing: border-box; /* Add this */
        }

        .submit-btn {
            background: var(--peach);
            color: var(--white);
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background: var(--pink);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New DIY Idea</h2>
        <form action="../actions/add_diy_idea.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="submit-btn">Submit DIY Idea</button>
        </form>
    </div>
</body>
</html>