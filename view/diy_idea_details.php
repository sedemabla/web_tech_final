<?php
session_start();
require_once '../db/db.php';

if (!isset($_GET['id'])) {
    header('Location: diy_ideas.php');
    exit();
}

$idea_id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT d.*, u.username,
                       COUNT(DISTINCT c.comment_id) as comment_count
                       FROM diy_ideas d
                       LEFT JOIN users u ON d.user_id = u.user_id
                       LEFT JOIN comments c ON d.idea_id = c.content_id 
                       AND c.content_type = 'diy_idea'
                       WHERE d.idea_id = ?
                       GROUP BY d.idea_id");
$stmt->bind_param("i", $idea_id);
$stmt->execute();
$idea = $stmt->get_result()->fetch_assoc();

if (!$idea) {
    header('Location: diy_ideas.php');
    exit();
}

// Get comments
$stmt = $conn->prepare("SELECT c.*, u.username 
                       FROM comments c 
                       JOIN users u ON c.user_id = u.user_id 
                       WHERE c.content_id = ? AND c.content_type = 'diy_idea'
                       ORDER BY c.created_at DESC");
$stmt->bind_param("i", $idea_id);
$stmt->execute();
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($idea['title']) ?> - DIY Idea</title>
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

        /* Use same styles as training_tip_details.php */
        /* ...existing styles from training_tip_details.php... */
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a href="diy_ideas.php" class="back-button">
            <i class='bx bx-arrow-back'></i>
            Back to DIY Ideas
        </a>
        <h1>Fur & Friends</h1>
        <nav>
            <a href="../index.php">Home</a>
            <a href="training_tips.php">Training Tips</a>
            <a href="health_tips.php">Health Tips</a>
            <a href="about.php">About Us</a>
        </nav>
    </div>

    <div class="container">
        <div class="tip-content">
            <?php if (!empty($idea['image_url'])): ?>
                <img src="../uploads/diy/<?= htmlspecialchars($idea['image_url']) ?>" 
                     alt="<?= htmlspecialchars($idea['title']) ?>" 
                     class="tip-image"
                     onerror="this.src='../assets/images/placeholder.jpg'">
            <?php endif; ?>

            <h1 class="tip-title"><?= htmlspecialchars($idea['title']) ?></h1>
            <p><strong>Created by:</strong> <?= htmlspecialchars($idea['username']) ?></p>
            
            <div class="tip-description">
                <?= nl2br(htmlspecialchars($idea['description'])) ?>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <h2>Comments</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="../actions/add_comment.php" method="POST">
                    <input type="hidden" name="content_type" value="diy_idea">
                    <input type="hidden" name="content_id" value="<?= $idea_id ?>">
                    <div>
                        <label>Comment:</label>
                        <textarea name="comment" required></textarea>
                    </div>
                    <button type="submit">Add Comment</button>
                </form>
            <?php endif; ?>

            <?php while ($comment = $comments->fetch_assoc()): ?>
                <div class="comment">
                    <p><?= htmlspecialchars($comment['comment_text']) ?></p>
                    <small>By <?= htmlspecialchars($comment['username']) ?> on 
                        <?= date('M d, Y', strtotime($comment['created_at'])) ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
