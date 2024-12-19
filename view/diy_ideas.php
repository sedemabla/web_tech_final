<?php
session_start();
require_once '../db/db.php';

// Add error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize $result
$result = null;

// Query to fetch DIY ideas with user and comment information
$query = "SELECT d.*, u.username, 
          (SELECT COUNT(*) FROM comments c 
           WHERE c.content_id = d.idea_id AND c.content_type = 'diy_idea') as comment_count
          FROM diy_ideas d
          LEFT JOIN users u ON d.user_id = u.user_id
          ORDER BY d.created_at DESC";

// Execute query with error handling
try {
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Error: " . $e->getMessage(); // Add this for debugging
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DIY Ideas - Fur & Friends</title>
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
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--light-pink);
            min-height: 100vh;
        }

        .banner {
            background: var(--dark-blue);
            color: var(--white);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .banner h1 {
            font-family: 'Fredoka One', cursive;
            margin: 0;
        }

        .banner nav a {
            color: var(--white);
            text-decoration: none;
            margin-left: 2rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .banner nav a:hover {
            color: var(--peach);
        }

        .content-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .content-container h2 {
            color: var(--dark-blue);
            font-family: 'Fredoka One', cursive;
            text-align: center;
            margin-bottom: 2rem;
        }

        .diy-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .diy-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: var(--dark-blue);
            display: flex;
            flex-direction: column;
        }

        .diy-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0,0,0,0.2);
        }

        .diy-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .diy-content {
            padding: 1.5rem;
        }

        .diy-content h3 {
            margin: 0 0 1rem;
            font-family: 'Fredoka One', cursive;
            color: var(--dark-blue);
        }

        .diy-content p {
            margin: 0 0 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        .diy-content small {
            display: block;
            color: var(--peach);
            margin-top: 0.5rem;
        }

        .add-btn {
            display: inline-block;
            background: var(--pink);
            color: var(--white);
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 2rem;
            transition: background-color 0.3s ease;
        }

        .add-btn:hover {
            background: var(--dark-blue);
        }

        @media (max-width: 768px) {
            .banner {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }

            .banner nav {
                margin-top: 1rem;
            }

            .banner nav a {
                margin: 0.5rem;
            }

            .diy-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="banner">
        <h1>Fur & Friends</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="training_tips.php">Training Tips</a>
            <a href="diy_ideas.php">DIY Ideas</a>
            <a href="about.php">About</a>
        </nav>
    </div>

    <div class="content-container">
        <h2>DIY Ideas for Your Pets</h2>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="add_diy_ideas.php" class="add-btn">+ Add DIY Idea</a>
        <?php endif; ?>

    <div class="diy-grid">
        <?php if (isset($result) && $result && $result->num_rows > 0): ?>
            <?php while($diy = $result->fetch_assoc()): ?>
                <a href="diy_idea_details.php?id=<?= $diy['idea_id'] ?>" class="diy-card">
                    <?php
                        $image_path = !empty($diy['image_url']) ? 
                            "../" . $diy['image_url'] : 
                            "../assets/images/placeholder.jpg";
                    ?>
                    <img src="<?= htmlspecialchars($image_path) ?>" 
                            alt="<?= htmlspecialchars($diy['title']) ?>" 
                            class="diy-image"
                            onerror="this.src='../assets/images/placeholder.jpg'">
                    <div class="diy-content">
                        <h3><?= htmlspecialchars($diy['title']) ?></h3>
                        <p><?= htmlspecialchars(substr($diy['description'], 0, 100)) ?>...</p>
                        <small>By <?= htmlspecialchars($diy['username']) ?></small>
                        <small><?= $diy['comment_count'] ?> comments</small>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No DIY ideas found. <?php if(isset($conn->error)) echo "Error: " . $conn->error; ?></p>
        <?php endif; ?>
    </div>
    </div>
</body>
</html>