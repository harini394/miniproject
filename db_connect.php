<?php
$servername = "localhost"; // Database host, usually localhost
$username = "root";        // Database username
$password = "";            // Database password (empty by default in XAMPP)
$dbname = "tour_db";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
