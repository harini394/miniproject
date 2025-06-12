<?php
session_start();
include('includes/db_connect.php');

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>Please login to submit a review.</p>";
    exit;
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $package_id = $_POST['package_id'];
    $review_text = trim($_POST['review_text']);
    $rating = (int)$_POST['rating'];

    if (!empty($review_text) && $rating >= 1 && $rating <= 5) {
        $sql = "INSERT INTO reviews (user_id, package_id, review_text, rating, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $user_id, $package_id, $review_text, $rating);

        if ($stmt->execute()) {
            header("Location: index.php?page=packages");
            exit;
        } else {
            echo "<p style='color: red;'>Failed to submit review.</p>";
        }
    } else {
        echo "<p style='color: red;'>Please provide a valid rating and review.</p>";
    }
}

// Get package_id from URL
$package_id = $_GET['package_id'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Write a Review</title>
    <style>
        body {
            background: url('images/review.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
            padding: 20px;
        }
        .review-form-container {
            background: rgba(0,0,0,0.7);
            padding: 20px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
        }
        textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: none;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background: #FFD700;
            border: none;
            color: black;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #e0c200;
        }
    </style>
</head>
<body>

<div class="review-form-container">
    <h2>Write a Review</h2>

    <form method="POST" action="index.php?page=review_form">
        <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($package_id); ?>">

        <label for="rating">Rating:</label>
        <select name="rating" id="rating" required>
            <option value="">Select rating</option>
            <option value="1">1 - Poor</option>
            <option value="2">2 - Fair</option>
            <option value="3">3 - Good</option>
            <option value="4">4 - Very Good</option>
            <option value="5">5 - Excellent</option>
        </select>

        <label for="review_text">Your Review:</label>
        <textarea name="review_text" id="review_text" rows="5" placeholder="Write your review here..." required></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>
