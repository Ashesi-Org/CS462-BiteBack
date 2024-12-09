<?php
require_once 'connection.php';

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to register.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$event_id = $data['event_id'] ?? null;

if (!$event_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid event ID.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the user is already registered
$check_query = $conn->prepare("SELECT * FROM user_events WHERE user_id = ? AND event_id = ?");
$check_query->bind_param("ii", $user_id, $event_id);
$check_query->execute();
$check_result = $check_query->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'You are already registered for this event.']);
    exit();
}

// Register the user
$insert_query = $conn->prepare("INSERT INTO user_events (user_id, event_id) VALUES (?, ?)");
$insert_query->bind_param("ii", $user_id, $event_id);

if ($insert_query->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to register for the event.']);
}
?>
