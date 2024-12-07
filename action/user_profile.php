<?php
session_start();
require_once '../../config/connection.php'; // Include the shared connection file

class UserProfile {
    private $db;
    private $user_id;

    public function __construct($db, $user_id) {
        $this->db = $db; // Use the connection from connection.php
        $this->user_id = $user_id;
    }

    public function getUserDetails() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getClimateActions() {
        $stmt = $this->db->prepare("SELECT * FROM climate_actions WHERE user_id = ? ORDER BY action_date DESC");
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecommendations() {
        // Example recommendation logic
        $actions = $this->getClimateActions();
        $recommendations = [];

        if (count($actions) < 3) {
            $recommendations[] = "Start your first climate action by attending a local event.";
        }

        // Add more recommendation logic based on user's profile and actions
        return $recommendations;
    }
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Create UserProfile instance with shared connection
$profile = new UserProfile($con, $_SESSION['user_id']);
$userDetails = $profile->getUserDetails();
$climateActions = $profile->getClimateActions();
$recommendations = $profile->getRecommendations();
?>
