<?php
// Database configuration
$host = 'localhost'; // or your database host
$username = 'root'; // default username for XAMPP
$password = ''; // default password for XAMPP (usually blank)
$database = 'clubs_events'; // your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
