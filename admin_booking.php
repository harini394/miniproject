<?php
session_start();
include('../includes/db_connect.php');


// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - User Bookings</title>
</head>
<body>

<h2>User Booking Details</h2>

<table>
    <tr>
        <th>Booking ID</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Package ID</th>
        <th>Adults</th>
        <th>Children</th>
        <th>Total Price</th>
        <th>Booking Date</th>
        <th>Status</th>
    </tr>

    <?php
    $query = "
        SELECT b.*, u.name, u.email, u.phone 
        FROM booking b
        JOIN users u ON b.user_id = u.user_id
    ";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['booking_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['package_id']}</td>
            <td>{$row['num_adults']}</td>
            <td>{$row['num_children']}</td>
            <td>₹{$row['total_price']}</td>
            <td>{$row['booking_date']}</td>
            <td>{$row['status']}</td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
<a href="contact_messages.php" class="arrow-btn">➜ View Contact Messages</a>
<style>
.arrow-btn {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s;
}
.arrow-btn:hover {
    background-color: #0056b3;
}
/* General page styles */
body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background-image: url('path/to/your/background-image.jpg'); /* Set your background image here */
    background-size: cover;
    background-position: center;
    color: #333;
    margin: 0;
    height: 100vh;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background for table */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 20px;
    text-align: left;
    border: 1px solid #ccc;
}

th {
    background-color: #007bff;
    color: white;
    font-size: 16px;
}

td {
    background-color: #f9f9f9;
}

h2 {
    text-align: center;
    color: #333;
    font-size: 30px;
    margin-bottom: 20px;
}

/* Button styles */
.arrow-btn {
    display: inline-block;
    background-color: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    font-size: 18px;
    transition: background-color 0.3s ease;
    margin-top: 20px;
    text-align: center;
    display: block;
    width: 250px;
    margin-left: auto;
    margin-right: auto;
}

.arrow-btn:hover {
    background-color: #218838;
}

/* Responsive styles */
@media screen and (max-width: 768px) {
    table {
        font-size: 14px;
        margin-top: 15px;
    }
    .arrow-btn {
        width: 200px;
    }
}

</style>
