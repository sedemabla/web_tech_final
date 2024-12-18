<?php
session_start();
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
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f6e8df;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #3e3c6e;
            font-family: 'Fredoka One', cursive;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #3e3c6e;
        }
        input, textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #fe979b;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        button:hover {
            background-color: #3e3c6e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add DIY Idea</h1>
        <form action="../actions/add_diy_idea.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required></textarea>
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <button type="submit">Add DIY Idea</button>
        </form>
    </div>
</body>
</html>