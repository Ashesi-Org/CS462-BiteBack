<?php
$host = 'localhost';        // Host (usually localhost)
$username = 'root';         // MySQL username
$password = '';             // MySQL password (leave blank if no password)
$database = 'ecomomentum';  // Your database name

// Create a connection to the MySQL database using MySQLi
$con= new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($con->connect_error) {
    // If the connection failed, display an error and stop execution
    die("Connection failed: " . $con->connect_error);
}


?>

