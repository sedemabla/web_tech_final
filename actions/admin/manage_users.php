<?php
session_start();
require_once '../../db/db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: ../../view/login.php');
    exit();
}

// Handle user deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
    $user_id = (int)$_GET['user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ? AND role != 1");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "User deleted successfully";
    } else {
        $_SESSION['error'] = "Error deleting user";
    }
    header('Location: ../../view/admin/manage-users.php');
    exit();
}

// Handle user role update
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $user_id = (int)$_POST['user_id'];
    $new_role = (int)$_POST['role'];
    
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE user_id = ?");
    $stmt->bind_param("ii", $new_role, $user_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "User role updated successfully";
    } else {
        $_SESSION['error'] = "Error updating user role";
    }
    header('Location: ../../view/admin/manage-users.php');
    exit();
}
?>