<?php
include('includes/db_connect.php');
include('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Prepare and execute the SQL query to insert contact data
        $stmt = $conn->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success = "Message sent successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Tours & Travel</title>
    <style>
        /* Your existing styles here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .contact-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
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

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: linear-gradient(90deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: linear-gradient(90deg, #218838, #1e7e34);
        }

        .message {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<main>
    <div class="contact-box">
        <h2>Contact Us</h2>
        <?php 
            if (isset($success)) echo "<p class='message success'>" . htmlspecialchars($success) . "</p>";
            if (isset($error)) echo "<p class='message error'>" . htmlspecialchars($error) . "</p>";
        ?>
        <form method="POST">
            <label>Your Name</label>
            <input type="text" name="name" required>

            <label>Your Email</label>
            <input type="email" name="email" required>

            <label>Subject</label>
            <input type="text" name="subject" required>

            <label>Message</label>
            <textarea name="message" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</main>

<?php include('includes/footer.php'); ?>

</body>
</html>
