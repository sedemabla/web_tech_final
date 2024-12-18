<?php
session_start();
require_once '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $errors = [];
    
    // Basic validation
    if (empty($username)) $errors[] = "Username is required";
    if (empty($password)) $errors[] = "Password is required";

    if (empty($errors)) {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, username, password_hash, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password - note we're using password_hash stored in DB
            if (password_verify($password, $user['password_hash'])) {
                // Password is correct - set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                if ($user['role'] == 1) {
                    header("Location: ../view/admin/admin_dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $_SESSION['error'] = "Invalid password";
            }
        } else {
            $_SESSION['error'] = "Username not found";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
    
    // If we get here, something went wrong
    header("Location: ../view/login.php");
    exit();
}

$conn->close();
?>
