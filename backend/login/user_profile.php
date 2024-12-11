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

        .description {
            margin-top: 10px;
            font-size: 1rem;
            color: #555;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        textarea, input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        #responseMessage {
            margin-top: 1rem;
        }

        #userProfile {
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>User Profile</h1>
    </header>

    <main>
        <div class="container">
            <h2>Update Profile</h2>
            <form id="profileForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" cols="50"></textarea>
                </div>

                <div class="form-group">
                    <label for="picture">Profile Picture</label>
                    <input type="file" id="picture" name="picture">
                </div>

                <button type="submit" id="submitBtn">Update Profile</button>
            </form>

            <div id="responseMessage"></div>

            <h3>Your Profile</h3>
            <div id="userProfile">
                <!-- Profile data will be loaded here -->
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch current user profile data when the page loads
            fetchUserProfile();

            // Handle form submission
            const profileForm = document.getElementById('profileForm');
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Get form data
                const formData = new FormData(profileForm);

                // Send AJAX request to update profile
                fetch('../action/profile_update.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const responseMessage = document.getElementById('responseMessage');
                    if (data.status === 'success') {
                        responseMessage.innerHTML = `<p style="color: green;">${data.message}</p>`;
                        // Display updated profile image
                        if (data.image) {
                            document.getElementById('userProfile').innerHTML = `
                                <img src="data:image/jpeg;base64,${data.image}" alt="Profile Image" width="100" height="100">
                                <p>${data.description}</p>
                            `;
                        }
                    } else {
                        responseMessage.innerHTML = `<p style="color: red;">${data.message}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error updating profile:', error);
                    document.getElementById('responseMessage').innerHTML = `<p style="color: red;">Error updating profile. Please try again later.</p>`;
                });
            });
        });

        // Function to fetch and display user profile
        function fetchUserProfile() {
            fetch('../action/profile_update.php', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const userProfile = document.getElementById('userProfile');
                    const profile = data.data;
                    if (profile.profile_image) {
                        userProfile.innerHTML = `
                            <img src="data:image/jpeg;base64,${profile.profile_image}" alt="Profile Image" width="100" height="100">
                            <p>${profile.description}</p>
                        `;
                    } else {
                        userProfile.innerHTML = `<p>No profile image available.</p>`;
                    }
                } else {
                    document.getElementById('userProfile').innerHTML = `<p>Error loading profile. Please try again later.</p>`;
                }
            })
            .catch(error => {
                console.error('Error fetching profile:', error);
                document.getElementById('userProfile').innerHTML = `<p>Error loading profile. Please try again later.</p>`;
            });
        }
    </script>
</body>
</html>
