<?php
include('../includes/db_connect.php');

// Check if a contact_id is passed through GET
if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];
    
    // Fetch the contact message from the database
    $query = $conn->prepare("SELECT * FROM contact WHERE contact_id = ?");
    $query->bind_param("i", $contact_id);
    $query->execute();
    $result = $query->get_result();
    $contact = $result->fetch_assoc();
}

// Handle the form submission for replying to the message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply = $_POST['reply']; 
    $reply = htmlspecialchars($reply, ENT_QUOTES, 'UTF-8');
    $date = date("Y-m-d H:i:s");

    if (!empty($reply)) {
        $update = $conn->prepare("UPDATE contact SET admin_reply = ?, reply_date = ?, status = 'Replied' WHERE contact_id = ?");
        $update->bind_param("ssi", $reply, $date, $contact_id);
        
        if ($update->execute()) {
            echo "<script>alert('Reply sent successfully!'); window.location.href='reply_message.php?id=$contact_id';</script>";
        } else {
            echo "<script>alert('Error sending reply. Please try again.'); window.location.href='reply_message.php?id=$contact_id';</script>";
        }
    } else {
        echo "<script>alert('Reply cannot be empty.'); window.location.href='reply_message.php?id=$contact_id';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reply to Message</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f4f8;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 220px;
        background-color: #2e3a59;
        padding: 20px;
        color: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        margin-bottom: 15px;
    }

    .sidebar ul li a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        display: block;
        padding: 10px;
        border-radius: 8px;
        transition: background-color 0.3s;
    }

    .sidebar ul li a:hover {
        background-color: #41597b;
    }

    .content {
        flex: 1;
        padding: 40px;
    }

    .content h2 {
        color: #2e3a59;
        margin-bottom: 25px;
    }

    .msg-info {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .msg-info p {
        margin-bottom: 12px;
        font-size: 15px;
        color: #333;
    }

    form textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 14px;
        resize: vertical;
    }

    form button {
        margin-top: 15px;
        padding: 10px 25px;
        background-color: #2e86de;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form button:hover {
        background-color: #1c6fce;
    }

    /* Bottom Links */
    .bottom-links {
        text-align: center;
        margin: 40px 0;
    }

    .bottom-links a {
        margin: 0 15px;
        text-decoration: none;
        font-weight: bold;
        color: #2e86de;
        font-size: 16px;
        border-bottom: 2px solid transparent;
        padding-bottom: 2px;
        transition: all 0.3s;
    }

    .bottom-links a:hover {
        border-bottom: 2px solid #2e86de;
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar for navigation -->
        <div class="sidebar">
            <ul>
                <li><a href="admin_booking.php">Booking History</a></li>
                <li><a href="contact_messages.php">Contact Messages</a></li>
                <li><a href="../index.php?page=home">🏠 Back to Home</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </div>

        <!-- Content area to display the contact message and reply form -->
        <div class="content">
            <h2>📩 Reply to Message</h2>
            <div class="msg-info">
                <p><strong>Name:</strong> <?= htmlspecialchars($contact['name']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($contact['email']); ?></p>
                <p><strong>Subject:</strong> <?= htmlspecialchars($contact['subject']); ?></p>
                <p><strong>Message:</strong><br> <?= nl2br(htmlspecialchars($contact['message'])); ?></p>
                <?php if (!empty($contact['admin_reply'])): ?>
                    <p><strong>Admin Reply:</strong><br> <?= nl2br(htmlspecialchars($contact['admin_reply'])); ?></p>
                <?php endif; ?>
            </div>

            <!-- Form to submit the reply message -->
            <form method="post">
                <label for="reply">Your Reply:</label><br>
                <textarea name="reply" rows="6" required></textarea><br>
                <button type="submit">✅ Send Reply</button>
            </form>
        </div>
    </div>
</body>
</html>
