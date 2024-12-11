<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once '../settings/connection.php';

// Check if the connection was successful
if (!$con) {
    die("Database connection failed. Please check your connection settings.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Check if the user exists in the users table
    $stmt = $con->prepare("SELECT id, email, password, role_id FROM users WHERE email = ?");
    if (!$stmt) {
        die("Database query preparation failed: " . $con->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['email'] = $user['email'];

            // Redirect based on role
            if ($user['role_id'] == 1) { // Role 1 is admin
                header("Location: ../admin/admin_dashboard_page.php"); // Admin dashboard
                exit();
            } else { // Regular user
                header("Location: ../admin/user_dashboard.php"); // User profile
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: ../login/login_page.php"); // Redirect back to login page with error
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: ../login/login_page.php"); // Redirect back to login page with error
        exit();
    }
}
?>
