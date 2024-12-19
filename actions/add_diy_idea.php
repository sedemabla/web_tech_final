<?php
session_start();
require_once '../db/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in.");
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    $errors = [];

    if (empty($title)) $errors[] = "Title is required.";
    if (empty($description)) $errors[] = "Description is required.";

    // Handle file upload
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadDir = '../uploads/diy/';
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $dest_path = $uploadDir . $fileName;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $image_url = $fileName;  // Store just filename
        } else {
            $errors[] = "There was an error moving the uploaded file.";
        }
    }

    if (empty($errors)) {
        $query = "INSERT INTO diy_ideas (user_id, title, description, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $user_id, $title, $description, $image_url);

        if ($stmt->execute()) {
            $_SESSION['success'] = "DIY idea added successfully!";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }

    header("Location: ../view/diy_ideas.php");
    exit();
}
?>