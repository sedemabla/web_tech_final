<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $confirmPassword = trim(mysqli_real_escape_string($conn, $_POST['confirm_password']));

    $errors = [];

    if (empty($username)) $errors[] = "Username is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";

    // Check for duplicate email and username
    $query = "SELECT user_id FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "Email or username already registered.";
    $stmt->close();

    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Signup successful! Please log in.";
            header("Location: ../view/login.php");
            exit();
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }

    header("Location: ../view/signup.php");
    exit();
}
?>