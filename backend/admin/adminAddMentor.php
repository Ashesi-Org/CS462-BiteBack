<?php
session_start();
include "../settings/connection.php";
<<<<<<< HEAD

=======
include "../core/core.php";
>>>>>>> 22d8ff08f12fd3bdd681e78ff77624a2e63f1ccd

// Check if user is admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Handle adding a mentor (only if the user is an admin)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
    $mentor_name = $_POST['mentor_name'];
    $mentor_expertise = $_POST['mentor_expertise'];
    $mentor_email = $_POST['mentor_email'];
    $mentor_twitter = $_POST['mentor_twitter'];
    $mentor_linkedin = $_POST['mentor_linkedin'];
    
    $stmt = $con->prepare("INSERT INTO mentors (name, expertise, email, twitter, linkedin) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $mentor_name, $mentor_expertise, $mentor_email, $mentor_twitter, $mentor_linkedin);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Mentor added successfully.";
    } else {
        $_SESSION['error'] = "Failed to add mentor. Please try again.";
    }
}

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

        .add-mentor-form {
            margin-top: 2rem;
            padding: 1.5rem;
            background: #ffffff;
            border: 1px solid #00563B;
            border-radius: 8px;
        }

        .add-mentor-form input, .add-mentor-form textarea {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #00563B;
            border-radius: 4px;
        }

        .add-mentor-form button {
            background-color: #00563B;
            color: #fff8e7;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-mentor-form button:hover {
            background-color: #003c29;
        }
    </style>
</head>
<body>
    <header>
        <a href="community.html">← Back to Community</a>
    </header>
    <div class="content">
        <h1>Find a Mentor</h1>

        <!-- Admin only section for adding a mentor -->
        <?php if ($isAdmin): ?>
            <div class="add-mentor-form">
                <h2>Add a New Mentor</h2>
                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="text" name="mentor_name" placeholder="Mentor Name" required>
                    <input type="text" name="mentor_expertise" placeholder="Expertise" required>
                    <input type="email" name="mentor_email" placeholder="Email" required>
                    <input type="url" name="mentor_twitter" placeholder="Twitter Profile URL">
                    <input type="url" name="mentor_linkedin" placeholder="LinkedIn Profile URL">
                    <button type="submit">Add Mentor</button>
                </form>
            </div>
        <?php endif; ?>

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
<<<<<<< HEAD
                <form action="add_event.php" method="POST" class="flex space-x-4">
    <input 
        type="text" 
        name="title" 
        placeholder="Event Title" 
        required 
        class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
    >
    <textarea 
        name="description" 
        placeholder="Event Description" 
        required 
        class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
    ></textarea>
    <input 
        type="date" 
        name="event_date" 
        required 
        class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
    >
    <button 
        type="submit" 
        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-300"
    >
        Create Event
    </button>
</form>
<?php
require_once '../settings/connection.php'; // Database connection

$query = "SELECT * FROM events ORDER BY event_date ASC";
$result = $con->query($query);
?>

<section class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Upcoming Events</h2>
    <div class="grid gap-6">
        <?php while ($event = $result->fetch_assoc()): ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-green-700"><?= htmlspecialchars($event['title']) ?></h3>
                <p class="text-gray-600"><?= htmlspecialchars($event['description']) ?></p>
                <small class="text-gray-500">Date: <?= htmlspecialchars($event['event_date']) ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</section>

=======
>>>>>>> 22d8ff08f12fd3bdd681e78ff77624a2e63f1ccd
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
