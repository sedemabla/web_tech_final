<?php
session_start();
require_once '../db/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $difficulty = $_POST['difficulty'];
    
    // Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../uploads/training/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $file_name = uniqid() . '.' . $file_ext;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = 'uploads/training/' . $file_name;
        }
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO training_tips (title, description, difficulty, image_path, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $description, $difficulty, $image_path, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Training tip added successfully!";
        header('Location: ../view/training_tips.php');
    } else {
        $_SESSION['error'] = "Error adding training tip";
        header('Location: ../view/add_training_tips.php');
    }
    exit();
}
?>