<?php
include('includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href = 'index.php?page=login';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_places'])) {
    $user_id = $_SESSION['user_id'];
    $selected = $_POST['selected_places'];
    $packname = $_POST['Packname'] ?? '';  // Make sure you're using 'Packname' if you're getting it from the form.

    // Prepare the SQL statement to insert into 'user_selections' table
    $stmt = $conn->prepare("INSERT INTO user_selections (user_id, place_name, place_type, packname) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind and execute for each selected place
    foreach ($selected as $item) {
        list($place_name, $place_type) = explode('|', $item);

        // Bind parameters: user_id, place_name, place_type, and packname (column name in DB is 'packname')
        $stmt->bind_param("isss", $user_id, $place_name, $place_type, $packname); // 'ss' for strings and 'i' for integers
        $stmt->execute();
    }

    // Once the booking is confirmed, display a success message
    echo "<script>alert('✅ Confirmed Booking for $packname'); window.location.href = 'index.php?page=home';</script>";
}
?>
