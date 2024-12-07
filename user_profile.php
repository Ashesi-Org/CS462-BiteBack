<?php
session_start();
require_once '../../config/database.php';

class UserProfile {
    private $db;
    private $user_id;

    public function __construct($user_id) {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user_id = $user_id;
    }

    public function getUserDetails() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getClimateActions() {
        $stmt = $this->db->prepare("SELECT * FROM climate_actions WHERE user_id = ? ORDER BY action_date DESC");
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecommendations() {
        // Logic to generate personalized recommendations based on user's actions
        $actions = $this->getClimateActions();
        $recommendations = [];

        // Example recommendation logic
        if (count($actions) < 3) {
            $recommendations[] = "Start your first climate action by attending a local event";
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

$profile = new UserProfile($_SESSION['user_id']);
$userDetails = $profile->getUserDetails();
$climateActions = $profile->getClimateActions();
$recommendations = $profile->getRecommendations();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile - Ecomomentum</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($userDetails['username']); ?></h1>
    
    <section>
        <h2>Your Climate Actions</h2>
        <?php foreach ($climateActions as $action): ?>
            <div>
                <p><?php echo htmlspecialchars($action['action_description']); ?></p>
                <small><?php echo htmlspecialchars($action['action_date']); ?></small>
            </div>
        <?php endforeach; ?>
    </section>

    <section>
        <h2>Recommendations</h2>
        <?php foreach ($recommendations as $recommendation): ?>
            <div>
                <p><?php echo htmlspecialchars($recommendation); ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>