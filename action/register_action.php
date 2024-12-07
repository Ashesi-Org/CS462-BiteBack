<?php
session_start();
include "../settings/connection.php"; 

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $fullName = filter_var($_POST['fullName'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Enhanced Validation
    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full name is required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Enhanced password validation
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one capital letter";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }

    if (!preg_match('/[!@#$%^&*]/', $password)) {
        $errors[] = "Password must contain at least one symbol (!@#$%^&*)";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Email is already registered";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL to insert new user
        $insertStmt = $con->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $defaultRole = 1; // Default user role
        $insertStmt->bind_param("sssi", $fullName, $email, $hashedPassword, $defaultRole);

        if ($insertStmt->execute()) {
            // Registration successful
            $_SESSION['success'] = "Registration successful. Please login.";
            header('Location: ../login/login.php');
            exit();
        } else {
            $_SESSION['error'] = "Registration failed: " . $insertStmt->error;
            header('Location: ../login/register.php');
            exit();
        }
    } else {
        // Store errors in session and redirect back to registration
        $_SESSION['errors'] = $errors;
        header('Location: ../login/register.php');
        exit();
    }
}
?>