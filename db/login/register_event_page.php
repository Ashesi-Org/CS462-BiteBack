<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            background-color: #2E8B57; /* Deep green background */
            color: white;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #006400; /* Dark green text */
        }
        .card {
            background-color: #f0f8f0; /* Light green card */
            border: 1px solid #006400; /* Dark green border */
        }
        .btn-primary {
            background-color: #006400; /* Dark green button */
            border-color: #004d00; /* Darker green border */
        }
        .btn-primary:hover {
            background-color: #004d00; /* Darker green on hover */
            border-color: #003300;
        }
        .alert-success {
            background-color: #b1bbb1;
            border-color: #004d00;
        }
        .alert-danger {
            background-color: #b22222;
            border-color: #8b0000;
        }
        .form-label {
            color: #004d00; /* Dark green label color */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Register for an Event</h1>
        
        <!-- Static Event Details -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title" id="eventName">COP  29 </h5>
                <p class="card-text" id="eventDescription">This is a description of the event.</p>
                <p><strong>Date:</strong> <span id="eventDate">2024-12-25</span></p>
                <p><strong>Location:</strong> <span id="eventLocation">Main Hall</span></p>
            </div>
        </div>

        <!-- Registration Form -->
        <form id="registrationForm" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="registerForEvent(1)">Register</button>
        </form>

        <!-- Response Message -->
        <div id="responseMessage" class="mt-3 text-center"></div>
    </div>

    <script>
        // Replace with the URL of your PHP script for registration
        const registerEventUrl = '../action/register_event.php';

        // Function to register for the event
        function registerForEvent(eventId) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            // Validate input
            if (!name || !email || !phone) {
                document.getElementById('responseMessage').innerHTML =
                    `<div class="alert alert-danger">Please fill in all fields.</div>`;
                return;
            }

            // Send data to backend
            axios.post(registerEventUrl, {
                event_id: eventId,
                name: name,
                email: email,
                phone: phone
            })
            .then(response => {
                const resMessage = document.getElementById('responseMessage');
                if (response.data.success) {
                    resMessage.innerHTML = `<div class="alert alert-success">Hello ${name}, you have successfully registered!</div>`;
                    document.getElementById('registrationForm').reset(); // Reset the form
                } else {
                    resMessage.innerHTML = `<div class="alert alert-success">Hello ${name}, you have successfully registered!</div>`
                }
            })
            .catch(error => {
                console.error('Error registering for event:', error);
                document.getElementById('responseMessage').innerHTML =
                    `<div class="alert alert-danger">An error occurred while processing your request.</div>`;
            });
        }
    </script>
</body>
</html>
