<?php
session_start();
require_once '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tip_id = (int)$_POST['tip_id'];
    $rating = min(5, max(1, (int)$_POST['rating']));
    $comment = trim($_POST['comment']);
    
    $stmt = $conn->prepare("INSERT INTO training_comments (tip_id, user_id, comment, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $tip_id, $_SESSION['user_id'], $comment, $rating);
    
    if ($stmt->execute()) {
        header("Location: ../view/training_tips_details.php?id=$tip_id");
    } else {
        $_SESSION['error'] = "Error adding comment";
        header("Location: ../view/training_tips_details.php?id=$tip_id");
    }
    exit();
}
?>