<?php
require_once 'connection.php';

// Fetch upcoming events from the database
$query = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoMomentum - Dashboard</title>
    <style>
        /* Same CSS as provided for dashboard */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
        }
        .sidebar {
            background-color: #00563B;
            width: 250px;
            height: 100vh;
            padding-top: 2rem;
            position: fixed;
            top: 0;
            left: 0;
            color: #fff;
            text-align: left;
            padding-left: 1rem;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2rem;
            display: block;
            padding: 1rem;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #ffd7a8;
            color: #00563B;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
            width: 100%;
        }
        header {
            background-color: #00563B;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        header .brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        header nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .section-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #00563B;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        .card h3 {
            font-size: 1.5rem;
            color: #00563B;
            margin-bottom: 0.5rem;
        }
        .card p {
            margin-bottom: 1rem;
            color: #555;
        }
        .card a {
            text-decoration: none;
            color: #00563B;
            font-weight: bold;
            border: 2px solid #00563B;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }
        .card a:hover {
            background-color: #00563B;
            color: #fff8e7;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="community.php">Community</a>
        <a href="impact.php">Impact</a>
        <a href="user_profile.php">My Profile</a>
        <a href="admin_dashboard_page.php">Administrator Dashboard</a>
        <a href="resources.php">Resource Hub</a>
    </div>

    <div class="content">
        <header>
            <div class="brand">EcoMomentum Dashboard</div>
            <nav>
                <a href="community.php">Community</a>
                <a href="impact.php">Impact</a>
                <a href="user_profile.php">My Profile</a>
                <a href="resources.php">Resource Hub</a>
            </nav>
        </header>

        <div class="container">
            <h2 class="section-title">Upcoming Events</h2>
            <div class="grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p>Date: <?= htmlspecialchars($row['event_date']) ?></p>
                        <p>Location: <?= htmlspecialchars($row['location']) ?></p>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                        <a href="register.php?event_id=<?= $row['event_id'] ?>">Register Now</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>
