<?php
session_start();
include "../settings/connection.php";

// Fetch community events
$query = "SELECT * FROM events ORDER BY event_date ASC";
$events = $con->query($query);

// Handle user joining an event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['join_event_id'])) {
    $event_id = intval($_POST['join_event_id']);
    $user_id = $_SESSION['user_id']; // Assume user_id is stored in the session

    // Check if user is already joined
    $checkQuery = $con->prepare("SELECT * FROM event_participants WHERE event_id = ? AND user_id = ?");
    $checkQuery->bind_param("ii", $event_id, $user_id);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "You have already joined this event.";
    } else {
        // Insert participant into the database
        $stmt = $con->prepare("INSERT INTO event_participants (event_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $event_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Successfully joined the event.";
        } else {
            $_SESSION['error'] = "Failed to join the event. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fridays for Future - Community</title>
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
            text-decoration: none;
            font-weight: bold;
            margin: 0 1rem;
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
            margin-bottom: 1rem;
        }

        .feature-card a {
            text-decoration: none;
            color: #00563B;
            font-weight: bold;
            border: 2px solid #00563B;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }

        .feature-card a:hover {
            background-color: #00563B;
            color: #fff8e7;
        }

        @media (max-width: 768px) {
            .feature-card {
                flex: 1 1 100%;
            }
        }

        .event-list {
            margin-top: 2rem;
        }

        .event-item {
            padding: 1rem;
            background-color: #fef8ed;
            border: 1px solid #00563B;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .event-item form {
            margin-top: 10px;
        }

        .event-item button {
            background-color: #00563B;
            color: #fff8e7;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .event-item button:hover {
            background-color: #003c29;
        }

        .success {
            color: green;
            margin-bottom: 1rem;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
    </header>
    <div class="content">
        <h1>Community</h1>
        <div class="features">
            <div class="feature-card">
                <h2>Networking</h2>
                <p>Connect with climate activists worldwide, share ideas, and collaborate on impactful projects to drive global change.</p>
                <a href="networking.php">Learn More</a>
            </div>
            <div class="feature-card">
                <h2>Mentorship</h2>
                <p>Find or become a mentor to guide and inspire others in their climate activism journey. Empower the next generation of leaders.</p>

                <a href="../view/findamentor.php">Find a Mentor</a>


            </div>
            <div class="feature-card">
                <h2>Global Collaboration</h2>
                <p>Participate in international campaigns and initiatives to amplify collective efforts in addressing the climate crisis.</p>
                <a href="global-collaboration.php">Get Involved</a>
            </div>
        </div>
    
    </div>
</body>
</html>
