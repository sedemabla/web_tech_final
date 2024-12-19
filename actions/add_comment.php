<?php
session_start();
require_once '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content_id = $_POST['content_id'];
    $content_type = $_POST['content_type'];
    $comment_text = trim($_POST['comment']);

    $stmt = $conn->prepare("INSERT INTO comments (user_id, content_id, content_type, comment_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $content_id, $content_type, $comment_text);
    
    if ($stmt->execute()) {
        // Determine redirect page based on content type
        switch ($content_type) {
            case 'health_tip':
                $redirect = "health_tips_details.php";
                break;
            case 'diy_idea':
                $redirect = "diy_idea_details.php";
                break;
            case 'training_tip':
                $redirect = "training_tip_details.php";
                break;
            default:
                $redirect = "health_tips.php";
        }
        
        header("Location: ../view/$redirect?id=$content_id");
    } else {
        // Log the error
        error_log("Comment insertion failed: " . $conn->error);
        header("Location: ../view/health_tips.php?error=1");
    }
    exit();
}

// Default redirect if not POST
header('Location: ../view/health_tips.php');
exit();
?>