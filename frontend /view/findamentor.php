<?php
session_start();
include "../settings/connection.php";


// Check if user is an admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Fetch mentors from the database
$query = "SELECT * FROM mentors ORDER BY name ASC";
$mentors = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Mentor</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #fff8e7;
            color: #00563B;
        }

        header {
            background-color: #00563B;
            padding: 1rem 0;
            text-align: center;
        }

        header a {
            color: #fff8e7;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            transition: color 0.3s;
        }

        header a:hover {
            color: #ffd7a8;
        }

        .content {
            max-width: 900px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .content h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .mentor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .mentor-card {
            flex: 1 1 calc(50% - 1rem);
            position: relative;
            padding: 1rem;
            background-color: #fef8ed;
            border: 1px solid #00563B;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mentor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .mentor-card h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #00563B;
        }

        .mentor-card p {
            margin: 0.5rem 0;
            font-size: 1rem;
            line-height: 1.4;
        }

        .hover-details {
            position: absolute;
            top: 0;
            left: 0;
            width: 120%;
            height: 120%;
            background: rgba(0, 86, 59, 0.9);
            color: #fff8e7;
            font-size: 0.9rem;
            line-height: 1.6;
            padding: 1rem;
            border-radius: 8px;
            display: none;
            justify-content: center;
            align-items: center;
            text-align: center;
            z-index: 10;
        }

        .mentor-card:hover .hover-details {
            display: flex;
            flex-direction: column;
        }

        .social-links {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .social-links a {
            color: #ffd7a8;
            text-decoration: none;
            margin: 0 0.5rem;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .mentor-card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <header>
<<<<<<< HEAD
        <a href="../view/community.php">← Back to Community</a>

    </header>
    <div class="content">
        <h1>Find a Mentor</h1>

        <!-- Display mentors list -->
        <div class="mentor-list">
            <?php while ($mentor = $mentors->fetch_assoc()): ?>
                <div class="mentor-card">
                    <h3><?php echo $mentor['name']; ?></h3>
                    <p>Expertise: <?php echo $mentor['expertise']; ?></p>
                    <div class="hover-details">
                        <p><?php echo $mentor['description']; ?></p>
                        <div class="social-links">
                            <p>Email: <?php echo $mentor['email']; ?></p>
                            <a href="<?php echo $mentor['twitter']; ?>" target="_blank">Twitter</a>
                            <a href="<?php echo $mentor['linkedin']; ?>" target="_blank">LinkedIn</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
