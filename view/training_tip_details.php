<?php
session_start();
require_once '../db/db.php';

if (!isset($_GET['id'])) {
    header('Location: training_tips.php');
    exit();
}

$tip_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT t.*, u.username, 
                       COALESCE(AVG(c.rating), 0) as avg_rating,
                       COUNT(DISTINCT c.comment_id) as comment_count
                       FROM training_tips t 
                       LEFT JOIN users u ON t.created_by = u.user_id
                       LEFT JOIN training_comments c ON t.tip_id = c.tip_id
                       WHERE t.tip_id = ?
                       GROUP BY t.tip_id");
$stmt->bind_param("i", $tip_id);
$stmt->execute();
$tip = $stmt->get_result()->fetch_assoc();

// Get comments
$stmt = $conn->prepare("SELECT c.*, u.username 
                       FROM training_comments c 
                       JOIN users u ON c.user_id = u.user_id 
                       WHERE c.tip_id = ? 
                       ORDER BY c.created_at DESC");
$stmt->bind_param("i", $tip_id);
$stmt->execute();
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tip['title']) ?> - Training Tip</title>
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

        /* Header Styles */
        .header {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-family: 'Fredoka One', cursive;
        }

        .header nav a {
            color: var(--white);
            text-decoration: none;
            margin-left: 20px;
            font-weight: 600;
        }

        .back-button {
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-button:hover {
            color: var(--peach);
        }

        /* Container and Content Styles */
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .tip-content {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .tip-title {
            color: var(--dark-blue);
            font-family: 'Fredoka One', cursive;
            font-size: 2em;
            margin: 0 0 20px 0;
        }

        .tip-difficulty {
            display: inline-block;
            background: var(--peach);
            color: var(--white);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-bottom: 20px;
        }

        .tip-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .tip-description {
            line-height: 1.8;
            color: #444;
            font-size: 1.1em;
        }

        /* Comments Section Styles */
        .comments-section {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .comments-section h2 {
            color: var(--dark-blue);
            font-family: 'Fredoka One', cursive;
            margin-top: 0;
        }

        .comment-form {
            margin: 20px 0;
            display: grid;
            gap: 15px;
        }

        .comment-form select,
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
        }

        .comment-form textarea {
            min-height: 100px;
            resize: vertical;
        }

        .comment-form button {
            background: var(--pink);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            width: fit-content;
        }

        .comment-form button:hover {
            background: var(--dark-blue);
        }

        .comment {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .rating {
            color: gold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .comment small {
            color: #666;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a href="training_tips.php" class="back-button">
            <i class='bx bx-arrow-back'></i>
            Back to Training Tips
        </a>
        <h1>Fur & Friends</h1>
        <nav>
            <a href="../index.php">Home</a>
            <a href="diy_ideas.php">DIY Ideas</a>
            <a href="health_tips.php">Health Tips</a>
            <a href="about.php">About Us</a>
        </nav>
    </div>

    <!-- Rest of the content -->
    <div class="container">
        <div class="tip-content">
            <?php 
            // Add debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            if (!empty($tip['image_path'])): 
                $image_path = "../" . $tip['image_path'];
                // Debug output
                echo "<!-- Debug: Image path = " . htmlspecialchars($image_path) . " -->";
            ?>
                <img src="<?= htmlspecialchars($image_path) ?>" 
                    alt="<?= htmlspecialchars($tip['title']) ?>" 
                    class="tip-image"
                    onerror="console.log('Image failed to load: ' + this.src); this.src='../assets/images/placeholder.jpg';">
            <?php else: ?>
                <!-- Debug: No image path found in database -->
                <img src="../assets/images/placeholder.jpg" 
                    alt="<?= htmlspecialchars($tip['title']) ?>" 
                    class="tip-image">
            <?php endif; ?>

            <h1 class="tip-title"><?= htmlspecialchars($tip['title']) ?></h1>
            <p class="tip-difficulty">Difficulty: <?= htmlspecialchars($tip['difficulty']) ?></p>
            
            <div class="tip-description">
                <?= nl2br(htmlspecialchars($tip['description'])) ?>
            </div>
        </div>

        <div class="comments-section">
            <h2>Comments</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="../actions/add_training_comment.php" method="POST">
                    <input type="hidden" name="tip_id" value="<?= $tip_id ?>">
                    <div>
                        <label>Rating:</label>
                        <select name="rating" required>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label>Comment:</label>
                        <textarea name="comment" required></textarea>
                    </div>
                    <button type="submit">Add Comment</button>
                </form>
            <?php endif; ?>

            <?php while ($comment = $comments->fetch_assoc()): ?>
                <div class="comment">
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?= $i <= $comment['rating'] ? '★' : '☆' ?>
                        <?php endfor; ?>
                    </div>
                    <p><?= htmlspecialchars($comment['comment']) ?></p>
                    <small>By <?= htmlspecialchars($comment['username']) ?> on 
                        <?= date('M d, Y', strtotime($comment['created_at'])) ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>