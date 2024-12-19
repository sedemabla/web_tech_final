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
    <link rel="stylesheet" href="../assets/css/diy_details.css">
    <style>
        .comments-section {
            background-color: var(--white);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .comment-form {
            margin-bottom: 2rem;
            width: 100%;
            box-sizing: border-box;
        }

        .comment-form textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 1rem;
            border: 2px solid var(--light-pink);
            border-radius: 8px;
            margin: 0 0 1rem 0;
            min-height: 100px;
            font-family: 'Poppins', sans-serif;
            resize: vertical;
        }

        .comment-form button {
            background: var(--peach);
            color: var(--white);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s ease;
        }

        .comment-form button:hover {
            background-color: var(--dark-blue);
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="diy_ideas.php" class="back-button">
            <i class='bx bx-arrow-back'></i> Back to DIY Ideas
        </a>
        <h1>Fur & Friends</h1>
    </div>

    <div class="diy-details-container">
        <div class="diy-content">
            <?php if (!empty($idea['image_url'])): ?>
                <img src="../uploads/diy/<?= htmlspecialchars($idea['image_url']) ?>" 
                     alt="<?= htmlspecialchars($idea['title']) ?>" 
                     class="diy-image"
                     onerror="this.src='../assets/images/placeholder.jpg'">
            <?php endif; ?>

            <h1><?= htmlspecialchars($idea['title']) ?></h1>
            
            <div class="diy-meta">
                <span>By <?= htmlspecialchars($idea['username']) ?></span>
                <span><?= $idea['comment_count'] ?> comments</span>
            </div>

            <div class="diy-description">
                <?= nl2br(htmlspecialchars($idea['description'])) ?>
            </div>
        </div>

        <div class="comments-section">
            <h2>Comments</h2>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="../actions/add_comment.php" method="POST">
                    <input type="hidden" name="content_type" value="diy_idea">
                    <input type="hidden" name="content_id" value="<?= $idea_id ?>">
                    <textarea name="comment" placeholder="Write your comment..." required></textarea>
                    <button type="submit">Post Comment</button>
                </form>
            <?php endif; ?>

            <div class="comments-list">
                <?php while ($comment = $comments->fetch_assoc()): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <strong><?= htmlspecialchars($comment['username']) ?></strong>
                            <small><?= date('M d, Y', strtotime($comment['created_at'])) ?></small>
                        </div>
                        <div class="comment-content">
                            <?= nl2br(htmlspecialchars($comment['comment_text'])) ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>
