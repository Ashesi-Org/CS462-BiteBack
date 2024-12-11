<?php
require_once '../settings/connection.php';

header('Content-Type: application/json');

session_start(); // Ensure sessions are enabled

$data = json_decode(file_get_contents('php://input'), true);

// Extract data from the request
$event_id = $data['event_id'] ?? null;
$name = $data['name'] ?? null;
$email = $data['email'] ?? null;
$phone = $data['phone'] ?? null;

if (!$event_id || !$name || !$email || !$phone) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Optional: Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit();
}

// Check if the user is already registered
$check_query = $con->prepare("SELECT * FROM user_events WHERE email = ? AND event_id = ?");
$check_query->bind_param("si", $email, $event_id);
$check_query->execute();
$check_result = $check_query->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'You are already registered for this event.']);
    exit();
}

// Register the user for the event
$insert_query = $con->prepare("INSERT INTO user_events (event_id, name, email, phone) VALUES (?, ?, ?, ?)");
$insert_query->bind_param("isss", $event_id, $name, $email, $phone);

if ($insert_query->execute()) {
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to register for the event.']);
}
?>
