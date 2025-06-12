<?php
include('includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to cancel a booking.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['user_id'];

    // Update the booking status to 'Canceled' (Note: 'Canceled' as per your ENUM definition)
    $stmt = $conn->prepare("UPDATE booking SET status = 'Canceled' WHERE booking_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);
    
    if ($stmt->execute()) {
        // If update is successful, redirect to booking history page
        echo "<script>
                alert('Your booking has been canceled.');
                window.location.href = 'index.php?page=booking_history';
              </script>";
    } else {
        echo "<script>
                alert('There was an error canceling your booking. Please try again.');
                window.location.href = 'index.php?page=booking_history';
              </script>";
    }
} else {
    // Redirect if the booking_id is not set or if there is an error
    echo "<script>
            alert('Invalid request.');
            window.location.href = 'index.php?page=booking_history';
          </script>";
}
?>
