<?php
session_start();
header('Content-Type: application/json');

// Check for logged-in user
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$host = 'localhost';
$dbname = 'ecomomentum';
$username = 'root';
$password = '';

// Establish connection
$con = new mysqli($host, $username, $password, $dbname);

if ($con->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Fetch user details
$userQuery = $con->prepare("SELECT full_name, email, profile_image FROM users WHERE id = ?");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userDetails = $userQuery->get_result()->fetch_assoc();

// Fetch dashboard statistics
$statsQuery = $con->prepare("SELECT 
    (SELECT COUNT(*) FROM climate_actions WHERE user_id = ?) AS events_attended,
    (SELECT COUNT(*) FROM climate_actions WHERE user_id = ? AND action_type = 'pledge') AS actions_pledged");
$statsQuery->bind_param("ii", $userId, $userId);
$statsQuery->execute();
$dashboardStats = $statsQuery->get_result()->fetch_assoc();

// Fetch upcoming events
$eventsQuery = $con->query("SELECT name, DATE_FORMAT(event_date, '%Y-%m-%d') AS date FROM events WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 5");
$upcomingEvents = $eventsQuery->fetch_all(MYSQLI_ASSOC);

// Fetch saved resources
$resourcesQuery = $con->prepare("SELECT title, resource_url AS url FROM resources WHERE resource_id IN (SELECT resource_id FROM user_resources WHERE user_id = ?)");
$resourcesQuery->bind_param("i", $userId);
$resourcesQuery->execute();
$savedResources = $resourcesQuery->get_result()->fetch_all(MYSQLI_ASSOC);

// Send response
echo json_encode([
    'status' => 'success',
    'data' => [
        'user_details' => $userDetails,
        'dashboard_stats' => $dashboardStats,
        'upcoming_events' => $upcomingEvents,
        'saved_resources' => $savedResources
    ]
]);

// Close the database connection
$con->close();
?>
