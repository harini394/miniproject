<?php
include('includes/db_connect.php');
include('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];

    // Check for duplicate email
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);

        if ($stmt->execute()) {
            $success = "Registration successful. You can now log in.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Tours & Travel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?auto=format&fit=crop&w=1650&q=80') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        .register-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            background: #f9f9f9;
        }
        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: linear-gradient(90deg, #ff7e5f, #feb47b);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: linear-gradient(90deg, #feb47b, #ff7e5f);
        }
        .message {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }
        .success { color: green; }
        .error { color: red; }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<main>
    <div class="register-box">
        <h2>Create Your Account</h2>
        <?php 
            if (isset($success)) echo "<p class='message success'>" . htmlspecialchars($success) . "</p>";
            if (isset($error)) echo "<p class='message error'>" . htmlspecialchars($error) . "</p>";
        ?>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Phone Number</label>
            <input type="text" name="phone" required>

            <label>Address</label>
            <textarea name="address" required></textarea>

            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="index.php?page=login">Login here</a>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
