<?php
session_start();

// Database connection
include('../includes/db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch the admin details based on the email
    $query = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the email exists
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Check if the entered password matches the stored one
        if ($password === $admin['password']) {
            // Password matched, log the admin in
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['email'] = $admin['email'];
            header('Location: admin_booking.php');
            exit();
        } else {
            // Password doesn't match
            echo "Invalid email or password!";
        }
    } else {
        // Email not found
        echo "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
/* General body styles */
body {
    font-family: 'Roboto', sans-serif;
    background: #f7f7f7;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #4b79a1, #283e51);
    color: #fff;
}

/* Container layout */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

/* Sidebar styles */
.sidebar {
    width: 250px;
    background-color: #333;
    padding: 30px;
    color: #fff;
    box-shadow: 5px 0 20px rgba(0, 0, 0, 0.2);
    border-radius: 15px 0 0 15px;
}

.sidebar h3 {
    font-size: 26px;
    text-align: center;
    margin-bottom: 50px;
}

/* Content area */
.content {
    background-color: #fff;
    color: #333;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.content h2 {
    font-size: 32px;
    margin-bottom: 20px;
    color: #2e3a59;
}

/* Form styling */
.content label {
    font-size: 16px;
    color: #555;
    display: block;
    margin-bottom: 8px;
}

.content input[type="email"],
.content input[type="password"] {
    width: 100%;
    padding: 15px;
    margin: 10px 0 20px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.content input[type="email"]:focus,
.content input[type="password"]:focus {
    border-color: #2e86de;
    outline: none;
}

/* Submit button styling */
.content input[type="submit"] {
    width: 100%;
    padding: 15px;
    background-color: #2e86de;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.content input[type="submit"]:hover {
    background-color: #1c6fce;
}

/* Bottom Links */
.bottom-links {
    text-align: center;
    margin-top: 30px;
}

.bottom-links a {
    margin: 0 20px;
    text-decoration: none;
    font-weight: 600;
    color: #2e86de;
    font-size: 18px;
    border-bottom: 2px solid transparent;
    padding-bottom: 2px;
    transition: all 0.3s ease;
}

.bottom-links a:hover {
    border-bottom: 2px solid #2e86de;
}

.bottom-links a:active {
    color: #1c6fce;
}
</style>
<body>

<div class="container">
    <!-- Sidebar (Optional) -->
    <div class="sidebar">
        <h3>Admin Panel</h3>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Login</h2>
        <form action="admin_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br><br>

            <input type="submit" value="Login">
        </form>

        <!-- Bottom Links -->
        <div class="bottom-links">
            <a href="../index.php?page=home">🏠 Back to Home</a>
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>
</div>

</body>
</html>
