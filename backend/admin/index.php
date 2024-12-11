<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {  // Check if the user is an admin
    header("Location: ../admin/dashboard.php");  // Redirect to a different page if not admin
    exit();
}

// Admin content here
echo "Welcome to the Admin Dashboard!";
?>
