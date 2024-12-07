<?php
session_start();
require_once '../../config/database.php';

class ResourceManager {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getResources($type = null, $limit = 10) {
        $query = "SELECT * FROM resources";
        
        if ($type !== null) {
            $query .= " WHERE resource_type = ?";
        }
        
        $query .= " ORDER BY created_at DESC LIMIT ?";
        
        $stmt = $this->db->prepare($query);
        
        if ($type !== null) {
            $stmt->bind_param("si", $type, $limit);
        } else {
            $stmt->bind_param("i", $limit);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchResources($keyword) {
        $keyword = "%$keyword%";
        $stmt = $this->db->prepare("SELECT * FROM resources WHERE title LIKE ? OR description LIKE ?");
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

$resourceManager = new ResourceManager();

// Handle different resource types
$resourceType = isset($_GET['type']) ? $_GET['type'] : null;
$resources = $resourceManager->getResources($resourceType);

// Handle search
$searchResults = [];
if (isset($_GET['search'])) {
    $searchResults = $resourceManager->searchResources($_GET['search']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Climate Resources - Ecomomentum</title>
</head>
<body>
    <h1>Climate Action Resources</h1>

    <form method="GET">
        <input type="text" name="search" placeholder="Search resources">
        <button type="submit">Search</button>
    </form>

    <div>
        <h2>Filter Resources</h2>
        <a href="?type=article">Articles</a>
        <a href="?type=video">Videos</a>
        <a href="?type=infographic">Infographics</a>
        <a href="?type=scientific_paper">Scientific Papers</a>
    </div>

    <section>
        <?php if (!empty($searchResults)): ?>
            <h2>Search Results</h2>
            <?php foreach ($searchResults as $resource): ?>
                <div>
                    <h3><?php echo htmlspecialchars($resource['title']); ?></h3>
                    <p><?php echo htmlspecialchars($resource['description']); ?></p>
                    <a href="<?php echo htmlspecialchars($resource['resource_url']); ?>" target="_blank">View Resource</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h2>Latest Resources</h2>
            <?php foreach ($resources as $resource): ?>
                <div>
                    <h3><?php echo htmlspecialchars($resource['title']); ?></h3>
                    <p><?php echo htmlspecialchars($resource['description']); ?></p>
                    <small>Type: <?php echo htmlspecialchars($resource['resource_type']); ?></small>
                    <a href="<?php echo htmlspecialchars($resource['resource_url']); ?>" target="_blank">View Resource</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>
</html>