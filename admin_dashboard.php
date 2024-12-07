<?php
session_start();
require_once '../config/database.php';

class AdminDashboard {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getUserStats() {
        $query = "SELECT 
            COUNT(*) as total_users,
            SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin_users,
            SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as regular_users
            FROM users";
        
        $result = $this->db->query($query);
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
        return $result->fetch_assoc();
    }

    public function getRecentActivities($limit = 10) {
        $query = "SELECT * FROM user_activities ORDER BY activity_date DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
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

$admin = new AdminDashboard();
$userStats = $admin->getUserStats();
$resourceStats = $admin->getResourceStats();
$recentActivities = $admin->getRecentActivities();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Ecomomentum</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <section>
        <h2>User Statistics</h2>
        <p>Total Users: <?php echo $userStats['total_users']; ?></p>
        <p>Admin Users: <?php echo $userStats['admin_users']; ?></p>
        <p>Regular Users: <?php echo $userStats['regular_users']; ?></p>
    </section>

    <section>
        <h2>Resource Statistics</h2>
        <p>Total Resources: <?php echo $resourceStats['total_resources']; ?></p>
        <p>Articles: <?php echo $resourceStats['articles']; ?></p>
        <p>Videos: <?php echo $resourceStats['videos']; ?></p>
        <p>Infographics: <?php echo $resourceStats['infographics']; ?></p>
    </section>

    <section>
        <h2>Recent Activities</h2>
        <?php foreach ($recentActivities as $activity): ?>
            <div>
                <p><?php echo htmlspecialchars($activity['activity_description']); ?></p>
                <small><?php echo htmlspecialchars($activity['activity_date']); ?></small>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>