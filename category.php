<?php
include('includes/db_connect.php');
include('includes/header.php');

$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get category name safely using prepared statements
$cat_name = "Selected Category";
$stmt = $conn->prepare("SELECT Cat_name FROM category WHERE Cat_id = ?");
$stmt->bind_param("i", $cat_id);
$stmt->execute();
$cat_result = $stmt->get_result();
if ($row = $cat_result->fetch_assoc()) {
    $cat_name = $row['Cat_name'];
}

// Fetch all packages under the selected category
$query = "
    SELECT p.*, sc.Subcat_name 
    FROM package p
    JOIN subcategory sc ON p.Subcatid = sc.Subcatid
    WHERE sc.Cat_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cat_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="category-section">
  <h2><?= htmlspecialchars($cat_name) ?> Packages</h2>
  <div class="package-grid">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="package-card">
            <img src="images/<?= htmlspecialchars($row['image']) ?>" class="package-image" alt="<?= htmlspecialchars($row['Packname']) ?>">
            <h3><?= htmlspecialchars($row['Packname']) ?></h3>
            <p><?= htmlspecialchars($row['Description']) ?></p>
            <p class="price">₹<?= number_format($row['Price']) ?></p>
            <div class="btn-group">
              <a href="index.php?page=booking&package_id=<?= $row['Packid'] ?>" class="btn book-btn">Book Now</a>
              <?php
                $place = explode(" in ", $row['Packname']);
                $search_place = end($place); 
              ?>
              <a href="index.php?page=place_explorer&place=<?= urlencode($search_place) ?>" class="btn explore-btn">Explore More</a>
            </div>
          </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No packages available in this category.</p>
    <?php endif; ?>
  </div>
</section>

<?php include('includes/footer.php'); ?>

<style>
  .category-section {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    text-align: center;
  }

  .package-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 30px;
  }

  .package-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    transition: 0.3s;
  }

  .package-card:hover {
    transform: translateY(-5px);
  }

  .package-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
  }

  .package-card h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #007bff;
  }

  .package-card p {
    color: #555;
    font-size: 14px;
  }

  .package-card .price {
    font-weight: bold;
    margin-top: 10px;
    color: #222;
  }

  .btn-group {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    justify-content: center;
  }

  .btn {
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
    background: #007bff;
  }

  .book-btn {
    background-color: #28a745;
  }

  .explore-btn {
    background-color: #17a2b8;
  }

  .btn:hover {
    opacity: 0.9;
  }
</style>
