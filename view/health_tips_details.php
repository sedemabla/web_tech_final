<?php
session_start();
require_once '../db/db.php';

// Validate tip ID
if (!isset($_GET['id'])) {
    header('Location: health_tips.php');
    exit();
}

$tip_id = (int)$_GET['id'];

// Fetch tip details
$stmt = $conn->prepare("SELECT h.*, u.username 
                       FROM health_tips h 
                       LEFT JOIN users u ON h.created_by = u.user_id 
                       WHERE h.tip_id = ?");
$stmt->bind_param("i", $tip_id);
$stmt->execute();
$tip = $stmt->get_result()->fetch_assoc();

// Fetch comments
$stmt = $conn->prepare("SELECT c.*, u.username 
                       FROM comments c 
                       JOIN users u ON c.user_id = u.user_id 
                       WHERE c.content_id = ? AND c.content_type = 'health_tip'
                       ORDER BY c.created_at DESC");
$stmt->bind_param("i", $tip_id);
$stmt->execute();
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tip['title']) ?> - Health Tip</title>
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

        .header {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-button {
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .tip-content {
            background: var(--white);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .tip-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .tip-meta {
            color: #666;
            font-size: 0.9rem;
            margin: 1rem 0;
        }

        .comments-section {
            margin-top: 2rem;
            background: var(--white);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .comment-form {
            margin-bottom: 2rem;
        }

        .comment-form textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px 0;
            font-family: 'Poppins', sans-serif;
            resize: vertical;
            min-height: 100px;
        }

        .comment-form button {
            background-color: var(--peach);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s;
        }

        .comment-form button:hover {
            background-color: var(--pink);
        }

        .comment {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .comment strong {
            color: var(--dark-blue);
            display: block;
            margin-bottom: 5px;
        }

        .comment p {
            margin: 8px 0;
            color: #444;
        }

        .comment small {
            color: #666;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="health_tips.php" class="back-button">
            <i class='bx bx-arrow-back'></i> Back to Health Tips
        </a>
        <h1>Fur & Friends</h1>
    </div>

    <div class="container">
        <div class="tip-content">
            <?php if (!empty($tip['image_path'])): ?>
                <img src="../<?= htmlspecialchars($tip['image_path']) ?>" 
                     alt="<?= htmlspecialchars($tip['title']) ?>" 
                     class="tip-image"
                     onerror="this.src='../assets/images/placeholder.jpg'">
            <?php endif; ?>

            <h1><?= htmlspecialchars($tip['title']) ?></h1>
            
            <div class="tip-meta">
                <span>By <?= htmlspecialchars($tip['username']) ?></span>
                <span>Category: <?= htmlspecialchars($tip['category']) ?></span>
            </div>

            <div class="tip-description">
                <?= nl2br(htmlspecialchars($tip['description'])) ?>
            </div>
        </div>

        <div class="comments-section">
            <h2>Comments</h2>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="../actions/add_comment.php" method="POST">
                    <input type="hidden" name="content_type" value="health_tip">
                    <input type="hidden" name="content_id" value="<?= $tip_id ?>">
                    <textarea name="comment" placeholder="Write your comment..." required></textarea>
                    <button type="submit">Post Comment</button>
                </form>
            <?php endif; ?>

            <?php while ($comment = $comments->fetch_assoc()): ?>
                <div class="comment">
                    <strong><?= htmlspecialchars($comment['username']) ?></strong>
                    <p><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                    <small><?= date('M d, Y', strtotime($comment['created_at'])) ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
