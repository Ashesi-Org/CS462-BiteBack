<?php
header('Content-Type: application/json');

require_once '../settings/connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_REQUEST['event_id'];

    if (empty($event_id)) {
        $response['message'] = 'Event ID is required.';
        echo json_encode($response);
        exit;
    }

    // Delete from database
    $query = "DELETE FROM events WHERE event_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Event deleted successfully.';
    } else {
        $response['message'] = 'Failed to delete event.';
    }
    $stmt->close();
}

echo json_encode($response);
