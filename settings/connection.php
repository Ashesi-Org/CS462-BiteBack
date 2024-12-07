<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Your MySQL password
$database = 'ecomomentum';

// Create connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


?>