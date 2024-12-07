<?php
session_start();
require_once '../config/connection.php'; // Include the new connection.php file

class AdminDashboard {
    private $db;

    public function __construct($connection) {
        $this->db = $connection; // Use the connection from connection.php
    }

    public function getUserStats() {
        $query = "SELECT 
            COUNT(*) as total_users,
            SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin_users,
            SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as regular_users
            FROM users";

        $result = $this->db->query($query);

        if (!$result) {
            die("Query failed: " . $this->db->error);
        }

        return $result->fetch_assoc();
    }

    public function getResourceStats() {
        $query = "SELECT 
            COUNT(*) as total_resources,
            SUM(CASE WHEN resource_type = 'article' THEN 1 ELSE 0 END) as articles,
            SUM(CASE WHEN resource_type = 'video' THEN 1 ELSE 0 END) as videos,
            SUM(CASE WHEN resource_type = 'infographic' THEN 1 ELSE 0 END) as infographics
            FROM resources";

        $result = $this->db->query($query);

        if (!$result) {
            die("Query failed: " . $this->db->error);
        }

        return $result->fetch_assoc();
    }

    public function getRecentActivities($limit = 10) {
        $query = "SELECT * FROM user_activities ORDER BY activity_date DESC LIMIT ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }

        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Initialize the AdminDashboard class
$admin = new AdminDashboard($con);
$userStats = $admin->getUserStats();
$resourceStats = $admin->getResourceStats();
$recentActivities = $admin->getRecentActivities();
?>
