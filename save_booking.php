<?php
include('includes/db_connect.php');

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input from the client
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['selections'])) {
        echo "No places selected!";
        exit;
    }

    // Save the general booking information (e.g., package info)
    $user_id = $_SESSION['user_id'];
    $selections = $data['selections'];

    // Insert booking data into the bookings table (assuming you have a 'bookings' table)
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, timestamp) VALUES (?, NOW())");

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
        exit;
    }

    // Get the last inserted booking ID
    $booking_id = $conn->insert_id;

    // Include the second file for saving the explore bookings, passing the booking_id
    include('save_explore_booking.php');  

    echo "Booking Confirmed!";
} else {
    echo "Invalid request method!";
}
?>
