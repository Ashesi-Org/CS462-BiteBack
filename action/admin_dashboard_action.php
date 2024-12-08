<?php
session_start();
require_once '../settings/connection.php'; // Include connection file

// Check if the user is logged in and has admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// Function to execute query and handle errors
function executeQuery($query,$con) {
    $result =$con->query($query);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Query execution failed.']);
        exit();
    }
    return $result;
}

// Fetch User Stats
$userStatsQuery = "SELECT 
                        COUNT(*) as total_users,
                        SUM(CASE WHEN role = 1 THEN 1 ELSE 0 END) as admin_users,
                        SUM(CASE WHEN role = 2 THEN 1 ELSE 0 END) as regular_users
                    FROM users";
$userStatsResult = executeQuery($userStatsQuery, $con);
$userStats = $userStatsResult->fetch_assoc();

// Fetch Resource Stats
$resourceStatsQuery = "SELECT 
                            COUNT(*) as total_resources,
                            SUM(CASE WHEN resource_type = 'article' THEN 1 ELSE 0 END) as articles,
                            SUM(CASE WHEN resource_type = 'video' THEN 1 ELSE 0 END) as videos,
                            SUM(CASE WHEN resource_type = 'infographic' THEN 1 ELSE 0 END) as infographics
                        FROM resources";
$resourceStatsResult = executeQuery($resourceStatsQuery, $con);
$resourceStats = $resourceStatsResult->fetch_assoc();

// Fetch Recent Activities
$recentActivitiesQuery = "SELECT * FROM user_activities ORDER BY activity_date DESC LIMIT 10";
$recentActivitiesResult = executeQuery($recentActivitiesQuery, $con);
$recentActivities = $recentActivitiesResult->fetch_all(MYSQLI_ASSOC);

// Return data as JSON
echo json_encode([
    'success' => true,
    'userStats' => $userStats,
    'resourceStats' => $resourceStats,
    'recentActivities' => $recentActivities
]);
?>
