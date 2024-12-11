<?php

require_once '../settings/connection.php'; // Ensure database connection

// Fetch content dynamically
$query = "SELECT title, description FROM impact_content";
$result = $con->query($query);


// Define placeholders
$content = [
    'Mission' => '',
    'Achievements' => '',
    'Impact' => '',
    'Future Goals' => ''
];

while ($row = $result->fetch_assoc()) {
    $content[$row['title']] = htmlspecialchars($row['description']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoMomentum - About/Impact</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #fff8e7;
            color: #00563B;
        }
        header {
            background-color: #00563B;
            color: #fff8e7;
            padding: 1rem;
            text-align: center;
        }
        header a {
            color: #fff8e7;
            text-decoration: underline;
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
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        .content p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
        }
        .feature-card {
            flex: 1 1 calc(50% - 1rem);
            padding: 1.5rem;
            background: #fef8ed;
            border: 1px solid #00563B;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        .feature-card h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #00563B;
        }
        .feature-card p {
            font-size: 1rem;
            line-height: 1.6;
            color: #333333;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 2rem;
            font-size: 1.1rem;
        }
        .back-link a {
            color: #00563B;
            text-decoration: none;
            font-weight: bold;
            border: 2px solid #00563B;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        .back-link a:hover {
            background-color: #00563B;
            color: #fff8e7;
        }
        @media (max-width: 768px) {
            .feature-card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <header>

        <a href="../admin/user_dashboard.php">← Back to Dashboard</a>

    </header>
    <div class="content">
        <h1>About EcoMomentum</h1>
        <p>Learn more about our mission, achievements, and the impact we’ve made so far.</p>
        <div class="features">
            <div class="feature-card">
                <h2>Mission</h2>
                <p><?= $content['Mission'] ?></p>
            </div>
            <div class="feature-card">
                <h2>Achievements</h2>
                <p><?= $content['Achievements'] ?></p>
            </div>
            <div class="feature-card">
                <h2>Impact</h2>
                <p><?= $content['Impact'] ?></p>
            </div>
            <div class="feature-card">
                <h2>Future Goals</h2>
                <p><?= $content['Future Goals'] ?></p>
            </div>

       
    </div>

</body>
</html>
