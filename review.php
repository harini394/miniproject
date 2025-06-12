<?php
include('includes/db_connect.php');
include('includes/header.php');
$sql = "SELECT r.*, u.name AS username 
        FROM reviews r 
        JOIN users u ON r.user_id = u.user_id 
        ORDER BY r.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    
    <style>
        body {
            background-image: url('images/review2.jpg'); /* Adjust path if needed */
            background-size: cover;
            background-repeat: no-repeat;
            padding: 20px;
            color: white;
        }
        .review-box {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .review-box h3 {
            margin: 0;
            color: #FFD700;
        }
        .review-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<h2>All User Reviews</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='review-box'>";
        echo "<h3>" . htmlspecialchars($row['username']) . "</h3>";
        echo "<p>Rating: " . $row['rating'] . "/5</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['review_text'])) . "</p>";
        echo "<p><em>" . $row['created_at'] . "</em></p>";
        echo "</div>";
    }
} else {
    echo "<p>No reviews found.</p>";
}
?>
<?php include('includes/footer.php'); ?>
</body>
</html>
