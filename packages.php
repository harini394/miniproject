<?php
include('includes/db_connect.php');
include('includes/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get all packages with category and subcategory
$query = "
    SELECT p.*, sc.Subcat_name, c.Cat_name 
    FROM package p
    JOIN subcategory sc ON p.Subcatid = sc.Subcatid
    JOIN category c ON sc.Cat_id = c.Cat_id
";
$result = mysqli_query($conn, $query);
?>

<div class="package-container">
    <h2>Explore Our Tour Packages</h2>
    <div class="packages-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="package-card">
                <?php
                    $imagePath = 'images/' . htmlspecialchars($row['image']);
                    if (!file_exists($imagePath)) {
                        $imagePath = 'images/default.jpg'; // Default image
                    }
                ?>
                <img src="<?= $imagePath; ?>" class="package-image" alt="<?= htmlspecialchars($row['Packname']); ?>">
                <div class="package-content">
                    <h3><?= htmlspecialchars($row['Packname']); ?></h3>
                    <p><strong>Category:</strong> <?= htmlspecialchars($row['Cat_name']); ?></p>
                    <p><strong>Subcategory:</strong> <?= htmlspecialchars($row['Subcat_name']); ?></p>
                    <p><?= htmlspecialchars($row['Description']); ?></p>
                    <p><strong>Price:</strong> ₹<?= number_format($row['Price']); ?></p>

                    <div class="btn-group">
                        <?php
                        // Extract location from the Packname (after "in" or "at")
                        $explore_place = $row['Packname'];
                        if (preg_match('/(?:in|at)\s+(.+)$/i', $row['Packname'], $match)) {
                            $explore_place = $match[1];
                        }
                        ?>
                        
                        <a href="index.php?page=place_explorer&place=<?= urlencode($explore_place); ?>&packname=<?= urlencode($row['Packname']); ?>" class="btn explore-btn">Explore More</a>

                        
                        <!-- Book Now Second -->
                        <a href="index.php?page=booking&packid=<?= $row['Packid']; ?>" class="btn book-btn">Book Now</a>

                        <!-- Write Review Third (Only if booked) -->
                        <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $package_id = $row['Packid'];

                                $checkStmt = $conn->prepare("SELECT 1 FROM booking WHERE user_id = ? AND package_id = ?");
                                $checkStmt->bind_param("ii", $user_id, $package_id);
                                $checkStmt->execute();
                                $checkStmt->store_result();

                                if ($checkStmt->num_rows > 0) {
                                    echo "<a href='index.php?page=review_form&package_id=$package_id' class='btn review-btn'>Write a Review</a>";
                                } 
                                $checkStmt->close();
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>



<style>
 body {
    background-image: url('images/packages.jpg'); /* Replace with your background image path */
    background-size: cover; /* Make the image cover the entire page */
    background-position: center center; /* Center the image */
    background-attachment: fixed; /* Keep the background fixed during scrolling */
    margin: 0;
    font-family: Arial, sans-serif;
    color: #333; /* Set default text color */
}



/* Apply background to the entire page */
body {
    background-image: url('images/packages.jpg'); 
    background-size: cover; /* Makes the background cover the entire page */
    background-position: center center; /* Center the background image */
    background-attachment: fixed; /* Keep the background fixed while scrolling */
    margin: 0;
    font-family: Arial, sans-serif;
}


h2 {
  text-align: center;
  font-size: 2.5rem;
  color: #333;
  margin-top: 50px;
  margin-bottom: 30px;
  font-weight: bold;
}

/* Container for the Packages Section */
.package-container {
  padding: 0 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.packages-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 50px;
}

/* Individual Package Card */
.package-card {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.package-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.package-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-bottom: 2px solid #eee;
}

.package-content {
  padding: 20px;
}

.package-content h3 {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 15px;
}

.package-content p {
  font-size: 1rem;
  color: #555;
  line-height: 1.6;
  margin-bottom: 10px;
}

.package-content p strong {
  color: #333;
}

/* Price Style */
.package-content .price {
  font-size: 1.2rem;
  font-weight: bold;
  color: #e91e63;
}

/* Button Group */
.btn-group {
  display: flex;
  gap: 10px;
  justify-content: center;
  margin-top: 20px;
}

.btn {
  padding: 10px 20px;
  font-size: 1rem;
  text-decoration: none;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.book-btn {
  background-color: #4caf50; /* Green for booking */
}

.book-btn:hover {
  background-color: #45a049;
}

.explore-btn {
  background-color: #2196f3; /* Blue for explore */
}

.explore-btn:hover {
  background-color: #1e88e5;
}

.review-btn {
  background-color: #ff9800; /* Orange for reviews */
}

.review-btn:hover {
  background-color: #fb8c00;
}

/* Responsive Design */
@media (max-width: 768px) {
  h2 {
    font-size: 2rem;
  }

  .packages-grid {
    grid-template-columns: 1fr;
  }

  .package-content {
    padding: 15px;
  }

  .package-card {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
}
</style>