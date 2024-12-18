<?php
session_start();
require_once '../db/db.php';

if (!isset($_GET['id'])) {
    header('Location: training_tips.php');
    exit();
}

$tip_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT t.*, AVG(c.rating) as avg_rating 
                       FROM training_tips t 
                       LEFT JOIN training_comments c ON t.tip_id = c.tip_id 
                       WHERE t.tip_id = ?
                       GROUP BY t.tip_id");
$stmt->bind_param("i", $tip_id);
$stmt->execute();
$tip = $stmt->get_result()->fetch_assoc();

if (!$tip) {
    header('Location: training_tips.php');
    exit();
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tip['title']) ?> - Training Tip</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
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
        .banner a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .content-container {
            margin: 30px auto;
            max-width: 800px;
            background: white; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        h1, h3 {
            color: #3e3c6e;
            font-family: 'Fredoka One', cursive;
        }
        p {
            line-height: 1.6;
        }
        .comment-form {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }

        .comments {
            margin-top: 20px;
        }

        .comment {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-container">
        <img src="<?= !empty($tip['image_path']) ? '../' . $tip['image_path'] : '../assets/images/placeholder.jpg' ?>" 
             alt="<?= htmlspecialchars($tip['title']) ?>" 
             class="tip-image">
        
        <h1><?= htmlspecialchars($tip['title']) ?></h1>
        <p class="difficulty">Difficulty: <?= htmlspecialchars($tip['difficulty']) ?></p>
        <div class="rating">
            <?php
            $rating = round($tip['avg_rating'] ?? 0);
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $rating ? '★' : '☆';
            }
            ?>
        </div>
        
        <div class="description">
            <?= nl2br(htmlspecialchars($tip['description'])) ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="comment-form">
                <h3>Leave a Review</h3>
                <form action="../actions/add_training_comment.php" method="POST">
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
                    <button type="submit">Submit Review</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="comments">
            <h3>Reviews</h3>
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
