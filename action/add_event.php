<?php
// Database connection
require_once '../settings/connection.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Ensure the connection is working
if ($con->connect_error) {
    $response['message'] = 'Database connection failed: ' . $con->connect_error;
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['event_title'];
    $event_date = $_POST['event_date'];
    $description = $_POST['event_description'];
    $location = $_POST['event_location'];

    // Validate inputs
    if (empty($name) || empty($event_date) || empty($description) || empty($location)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $query = "INSERT INTO events (name, event_date, description, location) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);

    // Check if statement preparation was successful
    if (!$stmt) {
        $response['message'] = 'SQL Prepare failed: ' . $con->error;
        echo json_encode($response);
        exit;
    }

    // Bind parameters
    $stmt->bind_param("ssss", $name, $event_date, $description, $location);

    // Execute the statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Event created successfully.';
    } else {
        $response['message'] = 'Failed to create event: ' . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If not a POST request
    $response['message'] = 'Invalid request method.';
}

// Send JSON response
echo json_encode($response);

// Close the database connection
$con->close();
?>