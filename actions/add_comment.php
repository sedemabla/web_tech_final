<?php
session_start();
require_once '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content_type = $_POST['content_type'];
    $content_id = (int)$_POST['content_id'];
    $comment_text = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    if (!empty($comment_text)) {
        $stmt = $conn->prepare("INSERT INTO comments (content_type, content_id, user_id, comment_text) 
                              VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $content_type, $content_id, $user_id, $comment_text);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Comment added successfully!";
        } else {
            $_SESSION['error'] = "Error adding comment.";
        }
    }

    header("Location: ../view/diy_idea_details.php?id=" . $content_id);
    exit();
}
?>