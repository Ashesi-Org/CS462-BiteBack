<?php
// Start the session to access session variables
session_start();  // This is necessary to get user session data

// Include the database connection file
include "../settings/connection.php";  // Include your actual connection file

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['picture'])) {
    $fileTmpPath = $_FILES['picture']['tmp_name'];  // Temporary file path
    $fileName = basename($_FILES['picture']['name']);  // Original file name
    $fileType = $_FILES['picture']['type']; // MIME type of the file

    // Validate image (check if file is an image)
    if (getimagesize($fileTmpPath)) {
        // Validate file size (max 5MB)
        if ($_FILES['picture']['size'] > 5000000) {
            echo json_encode(['status' => 'error', 'message' => 'File is too large.']);
        } else {
            // Read the file content into binary format (BLOB)
            $imageData = file_get_contents($fileTmpPath);

            // Assuming user ID is stored in session after successful login
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];  // Get logged-in user ID from session

                // Prepare SQL query to update the profile image in the database
                $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("bi", $null, $userId);  // BLOB data and user ID
                $stmt->send_long_data(0, $imageData);  // Send the binary data

                // Execute the query
                if ($stmt->execute()) {
                    // Fetch the newly uploaded image as base64
                    $sql = "SELECT profile_image FROM users WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $stmt->bind_result($profileImage);
                    $stmt->fetch();

                    if ($profileImage) {
                        // Convert binary data to base64
                        $base64Image = base64_encode($profileImage);

                        // Send the response with base64 encoded image
                        echo json_encode(['status' => 'success', 'message' => 'Profile image updated successfully!', 'image' => $base64Image]);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error fetching image.']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error updating profile image.']);
                }

                // Close the connection
                $stmt->close();
                $conn->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'User is not logged in.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
    }
}
?>
