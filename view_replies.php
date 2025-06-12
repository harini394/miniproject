<?php
include('includes/db_connect.php');
include('includes/header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $_POST['email']; // Get the email entered by the user
    if (!$user_email) {
        echo "Please enter a valid email.";
        exit;
    }

    // Fetching messages for the given email
    $sql = "SELECT * FROM contact WHERE email = ? AND (status = 'Replied' OR admin_reply IS NOT NULL) ORDER BY submitted_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Your Conversations with Admin</h2>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; margin:10px; padding:10px;'>";
            echo "<strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "<br>";
            echo "<strong>Your Message:</strong><br>" . nl2br(htmlspecialchars($row['message'])) . "<br><br>";

            if ($row['admin_reply']) {
                echo "<strong>Admin Reply:</strong><br>" . nl2br(htmlspecialchars($row['admin_reply'])) . "<br>";
                echo "<small>Replied on: " . $row['reply_date'] . "</small>";
            } else {
                echo "<strong>Admin Reply:</strong><br><i>No reply yet...</i><br>";
            }

            echo "<small>Status: " . htmlspecialchars($row['status']) . "</small><br>";

            // Reply box only if the message hasn't been replied to yet
            if ($row['status'] != 'Replied') {
                echo "
                    <form method='POST' action='reply_message.php'>
                        <input type='hidden' name='contact_id' value='{$row['contact_id']}'>
                        <textarea name='reply_message' placeholder='Type your reply here...' required style='width:100%; margin-top:10px;'></textarea><br>
                        <button type='submit' style='margin-top:5px;'>Reply to Admin</button>
                    </form>
                ";
            }
            echo "</div>";
        }
    } else {
        echo "<p>No messages from admin yet.</p>";
    }
} else {
    // If the form is not submitted, show the email input form
    echo "
    <h2>Enter Your Email to View Messages</h2>
    <form method='POST'>
        <input type='email' name='email' required placeholder='Enter your email' style='padding: 10px; width: 300px;'>
        <button type='submit' style='padding: 10px;'>View Messages</button>
    </form>
    ";
}
?>
