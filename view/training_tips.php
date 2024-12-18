<?php
// Include Database Connection
include('../db/db.php');
// Fetch Training Tips from the Database
$sql = "SELECT * FROM pet_training_tips"; // Assuming 'training_tips' is your table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Tips - Fur & Friends</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f6e8df;
        }
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
        .tip-card {
            display: flex;
            gap: 20px;
            align-items: center;
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .tip-card img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
        }
        .tip-card h3 {
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
            <a href="training_tips.php">Training Tips</a>
            <a href="diy_ideas.php">DIY Ideas</a>
            <a href="health_tips.php">Health Tips</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact</a>
        </nav>
    </div>

    <!-- Content -->
    <div class="content-container">
        <h2>Training Tips</h2>
        <a href="add_training_tips.php" class="add-btn">+ Add Your Own Training Tip</a>

        <!-- Training Tip Cards -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="training_tips_details.php?id=<?= $row['id'] ?>">
                    <div class="tip-card">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Training Tip">
                        <div>
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p><?= htmlspecialchars($row['description']) ?></p>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No training tips available. Be the first to add one!</p>
        <?php endif; ?>
    </div>
</body>
</html>
