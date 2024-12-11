<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef5f9;
            /* Light blue */
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #006400;
            /* Deep green */
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2e8b57;
            /* Deep Green */
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            color: white;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .sidebar li {
            margin: 15px 0;
            width: 100%;
            text-align: center;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            display: block;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #3cb371;
            /* Lighter Green */
        }

        .container {
            margin-left: 260px;
            padding: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .stat-box {
            width: 30%;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .stat-box:hover {
            transform: scale(1.05);
        }

        .stat-box h2 {
            color: #006400;
            /* Deep Green */
        }

        .recent-activities ul,
        .manage-events ul {
            list-style: none;
            padding: 0;
        }

        .recent-activities li,
        .manage-events li {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .recent-activities li:hover,
        .manage-events li:hover {
            background-color: #e3f2fd;
        }

        .btn-green {
            background-color: #00563B;
            /* Deep Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-green:hover {
            background-color: #00563B;
            /* Lighter Green */
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 8px;
            z-index: 1000;
        }

        .modal-content form input,
        .modal-content form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content form button {
            float: right;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="../admin/user_dashboard.php">Dashboard</a></li>
            <li><a href="#" id="create-event-btn">Create Event</a></li>
            <a href="../login/login.php" style="text-decoration: none;">Logout</a>
        </ul>
    </div>

    <h1>Welcome to the Admin Dashboard</h1>

    <div class="container">
        <div class="stats">
            <div class="stat-box">
                <h2>User Stats</h2>
                <p>Total Users: <span id="total-users"><?php echo $userStats['total_users']; ?></span></p>
                <p>Admin Users: <span id="admin-users"><?php echo $userStats['admin_users']; ?></span></p>
                <p>Regular Users: <span id="regular-users"><?php echo $userStats['regular_users']; ?></span></p>
            </div>
            <div class="stat-box">
                <h2>Event Stats</h2>
                <p>Total Events: <span id="total-events"></span></p>
            </div>
        </div>




        <div class="recent-activities">
            <h2>Recent Activities</h2>
            <ul id="activities-list"></ul>
        </div>

        <div class="manage-events">
            <h2>Manage Events</h2>
            <ul id="events-list">
                <!-- Dynamic event items will be populated here -->
            </ul>
        </div>
    </div>


    <div id="create-event-modal" class="modal">
        <div class="modal-content">
            <h2>Create Event</h2>
            <form id="create-event-form">
                <input type="text" name="event_title" placeholder="Event Title" required />
                <textarea name="event_description" placeholder="Event Description" required></textarea>
                <input type="date" name="event_date" required />
                <input type="text" name="event_location" placeholder="Event Location" required />
                <button type="submit" class="btn-green">Create Event</button>
            </form>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div id="edit-event-modal" class="modal">
        <div class="modal-content">
            <h2>Edit Event</h2>
            <form id="edit-event-form">
                <input type="hidden" name="event_id" id="event-id">
                <input type="text" name="event_title" id="edit-event-title" placeholder="Event Title" required />
                <textarea name="event_description" id="edit-event-description" placeholder="Event Description" required></textarea>
                <input type="date" name="event_date" id="edit-event-date" required />
                <input type="text" name="event_location" id="edit-event-location" placeholder="Event Location" required />
                <button type="submit" class="btn-green">Update Event</button>
            </form>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createEventBtn = document.getElementById('create-event-btn');
            const createEventModal = document.getElementById('create-event-modal');
            const createEventForm = document.getElementById('create-event-form');
            const editEventModal = document.getElementById('edit-event-modal');
            const editEventForm = document.getElementById('edit-event-form');
            const activitiesList = document.getElementById('activities-list');
            const eventsList = document.getElementById('events-list');
            const totalEvents = document.getElementById('total-events');

            // Open the create event modal
            createEventBtn.addEventListener('click', function() {
                createEventModal.style.display = 'block';
            });

            // Close modals when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === createEventModal || e.target === editEventModal) {
                    createEventModal.style.display = 'none';
                    editEventModal.style.display = 'none';
                }
            });

            // Fetch events and populate the list
            function fetchEvents() {
                fetch('../action/admin_get_events.php')
                    .then(response => response.json())
                    .then(data => {
                        // Populate events list
                        eventsList.innerHTML = '';
                        data.forEach(event => {
                            const eventItem = document.createElement('li');
                            eventItem.innerHTML = `
                            <h4>${event.name}</h4>
                            <p>${event.description}</p>
                            <p>${event.event_date}</p>
                            <p>${event.location}</p>
                            <button class="btn-green" onclick="editEvent(${event.event_id})">Edit</button>
                            <button class="btn-green" onclick="deleteEvent(${event.event_id})">Delete</button>
                        `;
                            eventsList.appendChild(eventItem);
                        });
                        totalEvents.textContent = data.length;
                    })
                    .catch(error => console.log('Error fetching events:', error));
            }

            // Fetch events on page load
            fetchEvents();
            fetchUserStats();

            function fetchUserStats() {
                fetch('../action/admin_dashboard_action.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const userStats = data.data;
                            document.getElementById('total-users').textContent = userStats.total_users;
                            document.getElementById('admin-users').textContent = userStats.admin_users;
                            document.getElementById('regular-users').textContent = userStats.regular_users;
                        } else {
                            console.log('Error fetching user stats:', data.message);
                        }
                    })
                    .catch(error => console.log('Error fetching user stats:', error));
            }
            createEventForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(createEventForm);
                fetch('../action/add_event.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            createEventModal.style.display = 'none';
                            fetchEvents(); // Update events list
                        } else {
                            console.log('Error:', data.message);
                        }
                    })
                    .catch(error => console.log('Error creating event:', error));
            });

            // Handle edit event
            window.editEvent = function(id) {
                console.log('Edit event clicked:', id); // Log to check if function is called
                fetch('../action/admin_get_events.php')
                    .then(response => response.json())
                    .then(data => {
                        const event = data.find(event => event.event_id == id);
                        if (event) {
                            document.getElementById('event-id').value = event.event_id;
                            document.getElementById('edit-event-title').value = event.name;
                            document.getElementById('edit-event-description').value = event.description;
                            document.getElementById('edit-event-date').value = event.event_date;
                            document.getElementById('edit-event-location').value = event.location;
                            editEventModal.style.display = 'block';
                        } else {
                            console.log('Event not found');
                        }
                    })
                    .catch(error => console.log('Error fetching event:', error));
            };

            // Handle edit event form submission
            editEventForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(editEventForm);
                fetch('../action/edit_event.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Event updated successfully');
                            editEventModal.style.display = 'none';
                            fetchEvents(); // Update events list
                        } else {
                            console.log('Error:', data.message);
                        }
                    })
                    .catch(error => console.log('Error updating event:', error));
            });



            window.deleteEvent = function(id) {
                console.log('Delete event clicked:', id); // Log to check if function is called
                if (confirm('Are you sure you want to delete this event?')) {
                    fetch(`../action/delete_event.php`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `event_id=${id}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Event deleted successfully');
                                fetchEvents(); // Update events list
                            } else {
                                console.log('Error:', data.message);
                            }
                        })
                        .catch(error => console.log('Error deleting event:', error));
                }
            };
        });
    </script>
</body>

</html>