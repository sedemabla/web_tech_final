<?php
session_start();
require_once '../../db/db.php';

// Check admin authorization
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Content-Type: application/json');
    die(json_encode(['error' => 'Unauthorized access']));
}

// Handle GET requests (fetch DIY)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'get') {
        $diy_id = (int)$_GET['diy_id'];
        $stmt = $conn->prepare("SELECT * FROM diy_ideas WHERE diy_id = ?");
        $stmt->bind_param("i", $diy_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $diy = $result->fetch_assoc();
        
        header('Content-Type: application/json');
        echo json_encode($diy);
        exit();
    }
    
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        $diy_id = (int)$_GET['diy_id'];
        $stmt = $conn->prepare("DELETE FROM diy_ideas WHERE diy_id = ?");
        $stmt->bind_param("i", $diy_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "DIY idea deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting DIY idea";
        }
        
        header('Location: ../../view/admin/manage-diy.php');
        exit();
    }
}

// Handle POST requests (create/update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $action = $_POST['action'];
    
    // Handle image upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../../uploads/diy/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $file_name = uniqid() . '.' . $file_ext;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = 'uploads/diy/' . $file_name;
        }
    }
    
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO diy_ideas (title, description, image_path, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $description, $image_path, $_SESSION['user_id']);
    } else {
        $diy_id = (int)$_POST['diy_id'];
        if ($image_path) {
            $stmt = $conn->prepare("UPDATE diy_ideas SET title = ?, description = ?, image_path = ? WHERE diy_id = ?");
            $stmt->bind_param("sssi", $title, $description, $image_path, $diy_id);
        } else {
            $stmt = $conn->prepare("UPDATE diy_ideas SET title = ?, description = ? WHERE diy_id = ?");
            $stmt->bind_param("ssi", $title, $description, $diy_id);
        }
    }
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "DIY idea " . ($action === 'add' ? "added" : "updated") . " successfully";
    } else {
        $_SESSION['error'] = "Error " . ($action === 'add' ? "adding" : "updating") . " DIY idea";
    }
    
    header('Location: ../../view/admin/manage-diy.php');
    exit();
}
?>