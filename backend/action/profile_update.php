<?php
session_start();
require_once '../settings/connection.php';  // Include the database connection

header('Content-Type: application/json');

// Handle POST request to update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
        exit();
    }

    // Initialize variables
    $description = $_POST['description'] ?? '';
    $imageData = null;

    // Handle image upload if exists
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $imageData = handleImageUpload($_FILES['picture']);
    }

    // Save profile description and image to the database
    $stmt = $con->prepare("UPDATE users SET description = ?, profile_image = ? WHERE id = ?");
    $stmt->bind_param("ssi", $description, $imageData, $user_id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Profile updated successfully!',
            'image' => $imageData  // Return base64 encoded image string
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
    }

    $stmt->close();
    exit();
}

// Handle GET request to fetch user profile details
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
        exit();
    }

    // Fetch user details
    $result = $con->query("SELECT full_name, email, description, profile_image FROM users WHERE id = $user_id");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user['profile_image'] = base64_encode($user['profile_image']);  // Base64 encode the image
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
    exit();
}

/**
 * Handle image upload and return base64 encoded image data.
 *
 * @param array $file Uploaded file data
 * @return string|null Base64 encoded image or null
 */
function handleImageUpload($file)
{
    // Define the target directory
    $targetDir = "uploads/";

    // Check if the uploads directory exists, if not, create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);  // Creates the folder with full write permissions
    }

    // Proceed with the rest of the code to handle file upload
    $imageTmpName = $file['tmp_name'];
    $imageName = basename($file['name']);
    $imagePath = $targetDir . $imageName;
    $imageType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

    // Validate file type (only allow image files)
    if (!in_array($imageType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid image type.']);
        exit();
    }

    // Validate file size (limit to 5MB)
    if ($file['size'] > 5000000) {
        echo json_encode(['status' => 'error', 'message' => 'File size is too large.']);
        exit();
    }

    // Sanitize the file name
    $sanitizedFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $imageName);

    // Check if file already exists
    if (file_exists($targetDir . $sanitizedFileName)) {
        echo json_encode(['status' => 'error', 'message' => 'File already exists.']);
        exit();
    }

    // Move uploaded file
    if (move_uploaded_file($imageTmpName, $targetDir . $sanitizedFileName)) {
        return base64_encode(file_get_contents($targetDir . $sanitizedFileName));  // Return base64 encoded image
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading the file.']);
        exit();
    }
}
