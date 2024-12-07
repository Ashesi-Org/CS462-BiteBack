<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../settings/connection.php';

// Enhanced admin access control
if (!isset($_SESSION['user_id']) || 
    (strtolower($_SESSION['role']) !== 'admin' && 
     strtolower($_SESSION['role']) !== 'administrator')) {
    $_SESSION['error'] = "Unauthorized access. Admin rights required.";
    header("Location: ../login/login.php");
    exit();
}

class AdminDashboard {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function getUserStats() {
        $query = "SELECT 
            COUNT(*) as total_users,
            SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin_users,
            SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as regular_users
            FROM users";

        $result = $this->db->query($query);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getResourceStats() {
        $query = "SELECT 
            COUNT(*) as total_resources,
            SUM(CASE WHEN resource_type = 'article' THEN 1 ELSE 0 END) as articles,
            SUM(CASE WHEN resource_type = 'video' THEN 1 ELSE 0 END) as videos,
            SUM(CASE WHEN resource_type = 'infographic' THEN 1 ELSE 0 END) as infographics
            FROM resources";

        $result = $this->db->query($query);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getRecentActivities($limit = 10) {
        $query = "SELECT * FROM user_activities ORDER BY activity_date DESC LIMIT ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return [];
        }

        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}

// Initialize dashboard
$admin = new AdminDashboard($con);
$userStats = $admin->getUserStats() ?: ['total_users' => 0, 'admin_users' => 0, 'regular_users' => 0];
$resourceStats = $admin->getResourceStats() ?: ['total_resources' => 0, 'articles' => 0, 'videos' => 0, 'infographics' => 0];
$recentActivities = $admin->getRecentActivities();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ecomomentum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-green-700">Admin Dashboard</h1>
            <div>
                <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></span>
                <a href="../login/logout.php" class="ml-4 bg-red-500 text-white px-4 py-2 rounded">Logout</a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <section class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">User Statistics</h2>
                <div class="space-y-4">
                    <?php
                    $userStatistics = [
                        ['label' => 'Total Users', 'value' => $userStats['total_users']],
                        ['label' => 'Admin Users', 'value' => $userStats['admin_users']],
                        ['label' => 'Regular Users', 'value' => $userStats['regular_users']]
                    ];

                    foreach ($userStatistics as $stat):
                    ?>
                    <div class="flex justify-between border-b pb-2 last:border-b-0">
                        <span><?php echo $stat['label']; ?></span>
                        <span class="font-bold text-green-600"><?php echo $stat['value']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Resource Statistics</h2>
                <div class="space-y-4">
                    <?php
                    $resourceStatistics = [
                        ['label' => 'Total Resources', 'value' => $resourceStats['total_resources']],
                        ['label' => 'Articles', 'value' => $resourceStats['articles']],
                        ['label' => 'Videos', 'value' => $resourceStats['videos']],
                        ['label' => 'Infographics', 'value' => $resourceStats['infographics']]
                    ];

                    foreach ($resourceStatistics as $stat):
                    ?>
                    <div class="flex justify-between border-b pb-2 last:border-b-0">
                        <span><?php echo $stat['label']; ?></span>
                        <span class="font-bold text-green-600"><?php echo $stat['value']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <section class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-green-700 mb-4">Recent Activities</h2>
            <?php if (!empty($recentActivities)): ?>
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="bg-green-50 p-4 rounded-md mb-4 border-l-4 border-green-500">
                        <p class="text-gray-700">
                            <?php echo htmlspecialchars($activity['activity_description']); ?>
                        </p>
                        <small class="text-gray-500">
                            <?php echo htmlspecialchars($activity['activity_date']); ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No recent activities found.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>