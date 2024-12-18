<?php
session_start();
require_once '../../db/db.php';

// Check admin authorization
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Content-Type: application/json');
    die(json_encode(['error' => 'Unauthorized access']));
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'get') {
        $tip_id = (int)$_GET['tip_id'];
        $stmt = $conn->prepare("SELECT * FROM training_tips WHERE tip_id = ?");
        $stmt->bind_param("i", $tip_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tip = $result->fetch_assoc();
        
        header('Content-Type: application/json');
        echo json_encode($tip);
        exit();
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        $tip_id = (int)$_GET['tip_id'];
        $stmt = $conn->prepare("DELETE FROM training_tips WHERE tip_id = ?");
        $stmt->bind_param("i", $tip_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Training tip deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting training tip";
        }
        
        header('Location: ../../view/admin/manage.php');
        exit();
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $difficulty = $_POST['difficulty'];
    $action = $_POST['action'];
    
    // Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../../uploads/training/';
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
    
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO training_tips (title, description, difficulty, image_path, created_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $title, $description, $difficulty, $image_path, $_SESSION['user_id']);
    } else {
        $tip_id = (int)$_POST['tip_id'];
        if ($image_path) {
            $stmt = $conn->prepare("UPDATE training_tips SET title = ?, description = ?, difficulty = ?, image_path = ? WHERE tip_id = ?");
            $stmt->bind_param("ssssi", $title, $description, $difficulty, $image_path, $tip_id);
        } else {
            $stmt = $conn->prepare("UPDATE training_tips SET title = ?, description = ?, difficulty = ? WHERE tip_id = ?");
            $stmt->bind_param("sssi", $title, $description, $difficulty, $tip_id);
        }
    }
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Training tip " . ($action === 'add' ? "added" : "updated") . " successfully";
    } else {
        $_SESSION['error'] = "Error " . ($action === 'add' ? "adding" : "updating") . " training tip";
    }
    
    header('Location: ../../action/admin/manage-training-tips.php');
    exit();
}
?>
