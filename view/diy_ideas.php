<?php
session_start();
require_once '../db/db.php';

// Fetch DIY ideas from the database
$query = "SELECT * FROM diy_ideas";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Ideas - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f6e8df;
        }
        /* Banner */
        .banner {
            background-color: #3e3c6e;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .banner h1 {
            margin: 0;
            font-family: 'Fredoka One', cursive;
        }
        .banner nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 600;
        }
        .banner nav a:hover {
            color: #feae97;
        }
        .content-container {
            margin: 20px auto;
            max-width: 1000px;
        }
        h2 {
            text-align: center;
            color: #3e3c6e;
        }
        .add-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #fe979b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .add-btn:hover {
            background-color: #3e3c6e;
        }
        .diy-card {
            display: flex;
            gap: 20px;
            align-items: center;
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .diy-card img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
        }
        .diy-card h3 {
            margin: 0;
            color: #3e3c6e;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <!-- Banner -->
    <div class="banner">
        <h1>Fur & Friends</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="training_tips.php">Tips & Training</a>
            <a href="diy_ideas.php">DIY Ideas</a>
            <a href="health_tips.php">Health Tips</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact</a>
        </nav>
    </div>

    <!-- Content -->
    <div class="content-container">
        <h2>DIY Ideas</h2>

        <!-- Add DIY Button -->
        <a href="add_diy_ideas.php" class="add-btn">+ Add Your Own DIY Idea</a>

        <!-- Display success or error messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- DIY Ideas List -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="diy-card">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="../assets/<?= htmlspecialchars($row['image_url']); ?>" alt="<?= htmlspecialchars($row['title']); ?>">
                    <?php endif; ?>
                    <div>
                        <h3><?= htmlspecialchars($row['title']); ?></h3>
                        <p><?= htmlspecialchars($row['description']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No DIY ideas available. Be the first to add one!</p>
        <?php endif; ?>
    </div>
</body>
</html>