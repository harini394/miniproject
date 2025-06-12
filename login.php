<?php
include('includes/db_connect.php');
include('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Fetch the user by email
    $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $name, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;

            header("Location: index.php?page=booking_history");
            exit();
        } else {
            $error = "Invalid login credentials.";
        }
    } else {
        $error = "Invalid login credentials.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Tours & Travel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: column; }
        main { flex: 1; background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e') no-repeat center center/cover; display: flex; justify-content: center; align-items: center; padding: 40px 20px; }
        .login-box { background-color: rgba(255, 255, 255, 0.95); padding: 40px 30px; border-radius: 20px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        label { font-weight: bold; display: block; margin-top: 15px; color: #333; }
        input[type="email"], input[type="password"] { width: 100%; padding: 12px; margin-top: 8px; border: 1px solid #ccc; border-radius: 10px; font-size: 14px; background: #f9f9f9; }
        input:focus { border-color: #007bff; outline: none; }
        button { width: 100%; margin-top: 25px; padding: 12px; background: linear-gradient(90deg, #007bff, #0056b3); color: white; border: none; border-radius: 10px; font-size: 16px; cursor: pointer; }
        button:hover { background: linear-gradient(90deg, #0056b3, #004080); transform: scale(1.05); }
        button:active { background: #004080; transform: scale(1); }
        .error { color: red; text-align: center; margin-top: 15px; font-size: 14px; }
        .register-link { text-align: center; margin-top: 20px; font-size: 14px; }
        .register-link a { color: #007bff; text-decoration: none; }
        .register-link a:hover { color: #0056b3; }
    </style>
</head>
<body>

<main>
    <div class="login-box">
        <h2>Welcome Back!</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            Don't have an account? <a href="index.php?page=register">Register here</a>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
