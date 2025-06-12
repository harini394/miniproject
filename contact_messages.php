
<?php
include('../includes/db_connect.php');

$result = $conn->query("SELECT * FROM contact ORDER BY submitted_at DESC");
?>

<h2>Contact Messages</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Date</th>
        <th>Status</th>
        <th>Reply</th>
    </tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['name']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['subject']; ?></td>
    <td><?= $row['message']; ?></td>
    <td><?= $row['submitted_at']; ?></td>
    <td><?= $row['status']; ?></td>
    <td><a href="reply_message.php?id=<?= $row['contact_id']; ?>">Reply</a></td>
</tr>
<?php endwhile; ?>

</table>

<style>
    /* General page styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fc; /* Light grey background */
    color: #333;
    padding: 20px;
    margin: 0;
    height: 100vh;
}

/* Table container styles */
h2 {
    text-align: center;
    color: #333;
    font-size: 30px;
    margin-bottom: 20px;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Table header styles */
th {
    background-color: #007bff; /* Blue background for header */
    color: white;
    padding: 12px 15px;
    font-size: 16px;
    text-align: left;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

/* Table cell styles */
td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 14px;
    background-color: #f9f9f9;
}

td a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

td a:hover {
    color: #0056b3;
}

/* Responsive Table */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }
    th, td {
        padding: 8px;
    }
}

</style>
