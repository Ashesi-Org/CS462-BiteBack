<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Your external CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #2c6e49; /* Green */
        }

        h2 {
            color: #2c6e49; /* Green */
            margin-top: 30px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .stat-box {
            padding: 20px;
            border-radius: 10px;
            background-color: #d0f7d3; /* Light Green */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s ease;
        }

        .stat-box:hover {
            background-color: #a4f0a4; /* Hover effect on stat boxes */
        }

        .stat-box p {
            font-size: 18px;
            margin: 10px 0;
        }

        .recent-activities ul {
            list-style: none;
            padding-left: 0;
        }

        .recent-activities li {
            background-color: #e9f5e7; /* Light Green */
            padding: 15px;
            margin-bottom: 8px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .recent-activities li:hover {
            background-color: #d3f3d2; /* Hover effect for recent activities */
        }

        /* Styling for error or success messages */
        .alert {
            padding: 10px;
            background-color: #ffcccc; /* Light red */
            color: red;
            margin: 20px 0;
            text-align: center;
        }

        /* Green button styles */
        .btn-green {
            background-color: #2c6e49; /* Dark Green */
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-green:hover {
            background-color: #1e4d37; /* Darker Green on hover */
        }
    </style>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>

    <div class="container">
        <div class="stats">
            <!-- User Stats Section -->
            <div class="stat-box">
                <h2>User Stats</h2>
                <p>Total Users: <span id="total-users"></span></p>
                <p>Admin Users: <span id="admin-users"></span></p>
                <p>Regular Users: <span id="regular-users"></span></p>
            </div>

            <!-- Resource Stats Section -->
            <div class="stat-box">
                <h2>Resource Stats</h2>
                <p>Total Resources: <span id="total-resources"></span></p>
                <p>Articles: <span id="articles"></span></p>
                <p>Videos: <span id="videos"></span></p>
                <p>Infographics: <span id="infographics"></span></p>
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="recent-activities">
            <h2>Recent Activities</h2>
            <ul id="activities-list">
                <!-- Activities will be dynamically inserted here -->
            </ul>
        </div>
    </div>

    <script>
        // Fetching dashboard data via AJAX
        fetch('../actions/dashboard_action.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fill in the user stats
                    document.getElementById('total-users').textContent = data.userStats.total_users;
                    document.getElementById('admin-users').textContent = data.userStats.admin_users;
                    document.getElementById('regular-users').textContent = data.userStats.regular_users;

                    // Fill in the resource stats
                    document.getElementById('total-resources').textContent = data.resourceStats.total_resources;
                    document.getElementById('articles').textContent = data.resourceStats.articles;
                    document.getElementById('videos').textContent = data.resourceStats.videos;
                    document.getElementById('infographics').textContent = data.resourceStats.infographics;

                    // List recent activities
                    const activitiesList = document.getElementById('activities-list');
                    data.recentActivities.forEach(activity => {
                        const li = document.createElement('li');
                        li.textContent = `${activity.activity_description} - ${activity.activity_date}`;
                        activitiesList.appendChild(li);
                    });
                } else {
                    alert(data.message); // Show error message if not successful
                }
            })
            .catch(error => console.error('Error fetching dashboard data:', error));
    </script>
</body>
</html>
