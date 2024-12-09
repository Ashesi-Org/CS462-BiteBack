<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        main {
            padding: 1rem;
            max-width: 900px;
            margin: auto;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .profile-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .profile-card {
            display: flex;
            align-items: center;
        }

        .dashboard {
            display: flex;
            justify-content: space-between;
        }

        .dashboard .item {
            flex: 1;
            text-align: center;
            background-color: #f1f8e9;
            margin: 0.5rem;
            border-radius: 5px;
            padding: 1rem;
        }

        .list {
            list-style: none;
            padding: 0;
        }

        .list li {
            margin: 0.5rem 0;
            background-color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .list a {
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome to Your Profile</h1>
    </header>
    <main>
        <!-- User Profile Section -->
        <div class="card profile-card">
            <img id="profile-image" src="default-avatar.png" alt="Profile Picture">
            <div>
                <h2 id="user-name">Loading...</h2>
                <p id="user-email">Loading...</p>
            </div>
        </div>

        <!-- Single Form for Uploading Profile Picture -->
        <form id="upload-form" action="../action/user_profile.php" method="POST" enctype="multipart/form-data">
            <label for="picture">Choose a profile picture:</label>
            <input type="file" name="picture" accept="image/*" required>
            <input type="submit" value="Upload Picture">
        </form>

        <!-- Dashboard Section -->
        <div class="card">
            <h3>Your Dashboard</h3>
            <div class="dashboard">
                <div class="item">
                    <h4>Events Attended</h4>
                    <p id="events-attended">0</p>
                </div>
                <div class="item">
                    <h4>Actions Pledged</h4>
                    <p id="actions-pledged">0</p>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="card">
            <h3>Upcoming Events</h3>
            <ul id="upcoming-events" class="list">
                <li>Loading...</li>
            </ul>
        </div>

        <!-- Saved Resources -->
        <div class="card">
            <h3>Saved Resources</h3>
            <ul id="saved-resources" class="list">
                <li>Loading...</li>
            </ul>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            fetchData();
        });

        function fetchData() {
            fetch('../action/user_profile.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        updateUI(data.data);
                    } else {
                        alert(data.message || "Error fetching data.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        function updateUI(data) {
            const { user_details, dashboard_stats, upcoming_events, saved_resources } = data;

            // Update profile info
            document.getElementById("user-name").textContent = user_details.full_name;
            document.getElementById("user-email").textContent = user_details.email;
            document.getElementById("profile-image").src = user_details.profile_image || "default-avatar.png";

            // Update dashboard
            document.getElementById("events-attended").textContent = dashboard_stats.events_attended;
            document.getElementById("actions-pledged").textContent = dashboard_stats.actions_pledged;

            // Update upcoming events
            const eventsList = document.getElementById("upcoming-events");
            eventsList.innerHTML = upcoming_events.map(event => `<li>${event.name} - ${event.date}</li>`).join("");

            // Update saved resources
            const resourcesList = document.getElementById("saved-resources");
            resourcesList.innerHTML = saved_resources.map(resource => 
                `<li><a href="${resource.url}" target="_blank">${resource.title}</a></li>`).join("");
        }
        
        document.getElementById("upload-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch('../action/user_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            // Update the profile image on the page with the base64-encoded image data
            document.getElementById("profile-image").src = `data:image/jpeg;base64,${data.image}`;
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});


