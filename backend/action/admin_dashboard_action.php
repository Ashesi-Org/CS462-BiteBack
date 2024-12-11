<?php
session_start();
require_once '../settings/connection.php'; // Include connection file

// Check if the user is logged in and has admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// Check for database connection error
if (!$con) {
    die("Database connection failed: " . $con->connect_error);
}



// Function to execute query and handle errors
function executeQuery($query, $con)
{
    $result = $con->query($query);
    if (!$result) {
        die("Query failed: " . $con->error);
    }
    return $result;
}

$userStatsQuery = "SELECT 
                     COUNT(*) as total_users,
                     SUM(CASE WHEN role_id = 1 THEN 1 ELSE 0 END) as admin_users,
                     SUM(CASE WHEN role_id = 2 THEN 1 ELSE 0 END) as regular_users
                FROM users";
$userStatsResult = $con->query($userStatsQuery);

if ($userStatsResult) {
    $userStats = $userStatsResult->fetch_assoc();
    $response['success'] = true;
    $response['data'] = $userStats;
} else {
    $response['message'] = 'Failed to fetch user statistics.';
}

echo json_encode($response);
