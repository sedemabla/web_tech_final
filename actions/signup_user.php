<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $lastName = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $confirmPassword = trim(mysqli_real_escape_string($conn, $_POST['confirm_password']));

    $errors = [];

    if (empty($firstName)) $errors[] = "First name is required.";
    if (empty($lastName)) $errors[] = "Last name is required.";
    if (empty($username)) $errors[] = "Username is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";

    // Check for duplicate email
    $query = "SELECT user_id FROM pet_users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "Email is already registered.";
    $stmt->close();

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO pet_users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $role = 2; // Default role for a normal user
        $stmt->bind_param("sssssi", $firstName, $lastName, $username, $email, $hashedPassword, $role);

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
