<?php
session_start();
require_once '../db/db.php';

// Add error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get filter parameters
$difficulty = isset($_GET['difficulty']) ? $conn->real_escape_string($_GET['difficulty']) : '';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Build query with proper JOIN syntax
$query = "SELECT t.*, 
          COALESCE(AVG(c.rating), 0) as avg_rating, 
          COUNT(DISTINCT c.comment_id) as comment_count 
          FROM training_tips t 
          LEFT JOIN training_comments c ON t.tip_id = c.tip_id";

// Add WHERE clause only if needed
$where = [];
if ($difficulty) {
    $where[] = "t.difficulty = '$difficulty'";
}
if ($search) {
    $where[] = "(t.title LIKE '%$search%' OR t.description LIKE '%$search%')";
}

if (!empty($where)) {
    $query .= " WHERE " . implode(' AND ', $where);
}

$query .= " GROUP BY t.tip_id ORDER BY t.created_at DESC";

try {
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception($conn->error);
    }
} catch (Exception $e) {
    error_log("Query error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred while fetching training tips";
}
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
        .filters {
            padding: 20px;
            background: var(--white);
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .tip-card {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer; /* Add cursor pointer */
        }
        .tip-card:hover {
            transform: translateY(-5px);
        }
        .tip-card a {
            text-decoration: none;
            color: inherit;
            display: block; /* Make anchor fill the card */
        }
        .tip-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .tip-content {
            padding: 15px;
        }
        .rating {
            color: #FFD700;
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
            <a href="../index.php">Home</a>
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

        <div class="filters">
            <form action="" method="GET">
                <select name="difficulty">
                    <option value="">All Difficulties</option>
                    <option value="Beginner" <?= $difficulty == 'Beginner' ? 'selected' : '' ?>>Beginner</option>
                    <option value="Intermediate" <?= $difficulty == 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
                    <option value="Advanced" <?= $difficulty == 'Advanced' ? 'selected' : '' ?>>Advanced</option>
                </select>
                <input type="text" name="search" placeholder="Search tips..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Filter</button>
            </form>
        </div>

        <div class="tips-grid">
            <?php while ($tip = $result->fetch_assoc()): ?>
                <a href="training_tip_details.php?id=<?= $tip['tip_id'] ?>">
                    <div class="tip-card">
                        <img src="<?= !empty($tip['image_path']) ? 
                            "../" . htmlspecialchars($tip['image_path']) : 
                            "../assets/images/placeholder.jpg" ?>" 
                            alt="<?= htmlspecialchars($tip['title']) ?>" 
                            class="tip-image"
                            onerror="this.src='../assets/images/placeholder.jpg'">
                        <div class="tip-content">
                            <h3><?= htmlspecialchars($tip['title']) ?></h3>
                            <p>Difficulty: <?= htmlspecialchars($tip['difficulty']) ?></p>
                            <div class="rating">
                                <?php
                                $rating = round($tip['avg_rating'] ?? 0);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '★' : '☆';
                                }
                                ?>
                                (<?= $tip['comment_count'] ?> reviews)
                            </div>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
