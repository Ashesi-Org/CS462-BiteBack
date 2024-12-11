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
    $event_id = $_POST['event_id'];
    $name = $_POST['event_title'];  // Changed from 'name' to match form
    $event_date = $_POST['event_date'];
    $description = $_POST['event_description'];  // Changed from 'description' to match form
    $location = $_POST['event_location'];  // Changed from 'location' to match form

    // Validate input
    if (empty($event_id) || empty($name) || empty($event_date) || empty($description) || empty($location)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    // Prepare update statement
    $query = "UPDATE events SET name = ?, event_date = ?, description = ?, location = ? WHERE event_id = ?";
    $stmt = $con->prepare($query);

    // Check if statement preparation was successful
    if (!$stmt) {
        $response['message'] = 'SQL Prepare failed: ' . $con->error;
        echo json_encode($response);
        exit;
    }

    // Bind parameters
    $stmt->bind_param("ssssi", $name, $event_date, $description, $location, $event_id);

    // Execute the statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Event updated successfully.';
    } else {
        $response['message'] = 'Failed to update event: ' . $stmt->error;
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