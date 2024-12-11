<?php
header('Content-Type: application/json');
// Include your database connection
include '../settings/connection.php'; // Replace with your connection file

// Fetch events from the database
$sql = "SELECT * FROM events"; // Replace 'events' with your table name
$result = $con->query($sql);

// Check if events exist
if ($result->num_rows > 0) {
    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row; // Add each event to the array
    }
    // Output events as JSON
    echo json_encode($events);
} else {
    // No events found
    echo json_encode([]);
}

// Close the database connection
$con->close();
?>
