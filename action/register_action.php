<?php
session_start();
include "../settings/connection.php";

if (!$con) {
    error_log("Database connection failed.", 3, "errors.log");
    die("Database connection failed.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $full_name = htmlspecialchars($_POST['fullName'], ENT_QUOTES, 'UTF-8');
    $isAdmin = isset($_POST['isAdmin']) && $_POST['isAdmin'] == '1';

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/register.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        if ($isAdmin) {
            // Admin registration
            $stmt = $con->prepare("INSERT INTO users (email, password, full_name, role_id) VALUES (?, ?, ?, 1)");
            if (!$stmt) {
                throw new Exception("Query preparation failed: " . $con->error);
            }
            $stmt->bind_param("sss", $email, $hashedPassword, $full_name);
            if (!$stmt->execute()) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
            $_SESSION['message'] = "Admin registered successfully!";
        } else {
            // Regular user registration
            $stmt = $con->prepare("INSERT INTO users (email, password, full_name, role_id) VALUES (?, ?, ?, 2)");
            if (!$stmt) {
                throw new Exception("Query preparation failed: " . $con->error);
            }
            $stmt->bind_param("sss", $email, $hashedPassword, $full_name);
            if (!$stmt->execute()) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
            $_SESSION['message'] = "User registered successfully!";
        }

        header("Location: ../login/login.php");
        exit();
    } catch (Exception $e) {
        error_log($e->getMessage(), 3, "errors.log");
        $_SESSION['errors'] = ["A system error occurred. Please try again later."];
        header("Location: ../views/register.php");
        exit();
    }
}
?>