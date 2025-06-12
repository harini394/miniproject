<?php
include('includes/db_connect.php');
include('includes/header.php');

// Fetch packages
$package_query = "SELECT * FROM package LIMIT 10";
$package_result = mysqli_query($conn, $package_query);

// Fetch reviews
$review_query = "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5";
$review_result = mysqli_query($conn, $review_query);

// Fetch categories
$cat_query = mysqli_query($conn, "SELECT * FROM category");
?>
<!-- Background Wrapper -->
<div class="home-wrapper">
  <!-- Slideshow -->
  <div class="slideshow-container">
    <div class="slide fade">
      <img src="images/img1.jpg" alt="Slide 1">
      <div class="caption"></div>
    </div>
    <div class="slide fade">
      <img src="images/img2.jpg" alt="Slide 2">
      <div class="caption"></div>
    </div>
    <div class="slide fade">
      <img src="images/img3.jpg" alt="Slide 3">
      <div class="caption"></div>
    </div>
  </div>
</div>

<!-- About Section -->
<section class="section about">
  <div class="about-wrapper">
    <div class="about-content">
      <h2>About Us</h2>
      <p>We curate unforgettable travel experiences for every kind of traveler — mountains, beaches, cities, and more!</p>
      <p>At our core, we believe in creating customized travel experiences that cater to your unique interests, whether you're looking for adventure, relaxation, or cultural exploration.</p>
      <div class="about-team">
        <h3>Meet Our Team</h3>
        <div class="team-members">
          <div class="team-member">
            <div class="team-icon">D</div>
            <h4>Deepika</h4>
            <p>Lead Planner</p>
          </div>
          <div class="team-member">
            <div class="team-icon">E</div>
            <h4>Eswari</h4>
            <p>Tour Expert</p>
          </div>
          <div class="team-member">
            <div class="team-icon">H</div>
            <h4>Harini</h4>
            <p>Travel Consultant</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Browse by Category -->
<section class="section categories">
  <h2>Browse by Category</h2>
  <div class="category-container">
    <?php while ($cat = mysqli_fetch_assoc($cat_query)) {
      $cat_id = $cat['Cat_id'] ?? '';
      $cat_name = $cat['Cat_name'] ?? 'Unknown Category';
      echo "<a href='index.php?page=category&id=$cat_id' class='category-card'>$cat_name</a>";
    } ?>
  </div>
</section>

<!-- Popular Packages -->
<section class="section popular">
  <h2>Popular Travel Packages</h2>
  <div class="package-grid">
    <?php while ($row = mysqli_fetch_assoc($package_result)) {
      // Extract location from Packname (like "in Tokyo")
      $explore_parts = preg_split('/ in | at /i', $row['Packname']);
      $search_place = end($explore_parts);
    ?>
      <div class="package-card">
        <h3><?= htmlspecialchars($row['Packname']) ?></h3>
        <p><?= htmlspecialchars($row['Description']) ?></p>
        <p class="price">₹<?= number_format($row['Price'], 2) ?></p>
        
        <div class="btn-group">
          <a href="index.php?page=booking&packid=<?= $row['Packid'] ?>" class="btn book-btn">Book Now</a>
          <a href="index.php?page=place_explorer&place=<?= urlencode($search_place) ?>" class="btn explore-btn">Explore Now</a>
        </div>
      </div>
    <?php } ?>
  </div>
</section>



<!-- Reviews 
<section class="section reviews">
  <h2>User Reviews</h2>
  <div class="review-grid">
    <?php while ($rev = mysqli_fetch_assoc($review_result)) { ?>
      <div class="review-card">
        <strong><?= htmlspecialchars($rev['user_name']) ?></strong> rated <?= $rev['rating'] ?>/5
        <p><?= htmlspecialchars($rev['review_text']) ?></p>
        <small><?= $rev['created_at'] ?></small>
      </div>
    <?php } ?>
  </div>
</section>--->


<?php
// Fetch the latest 5 reviews with user name
$review_query = "
  SELECT r.*, u.name AS user_name 
  FROM reviews r 
  JOIN users u ON r.user_id = u.user_id 
  ORDER BY r.created_at DESC 
  LIMIT 5
";
$review_result = mysqli_query($conn, $review_query);
?>

<!-- User Reviews Section -->
<section class="section reviews">
  <h2>User Reviews</h2>
  <div class="review-grid">
    <?php if (mysqli_num_rows($review_result) > 0): ?>
      <?php while ($rev = mysqli_fetch_assoc($review_result)): ?>
        <div class="review-card">
          <strong><?= htmlspecialchars($rev['user_name']) ?></strong> rated <?= $rev['rating'] ?>/5
          <p><?= htmlspecialchars($rev['review_text']) ?></p>
          <small><?= $rev['created_at'] ?></small>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center;">No reviews yet.</p>
    <?php endif; ?>
  </div>
</section>





<!-- Contact -->
<section class="section contact">
  <h2>Contact Us</h2>
  <p>Email: contact@toursntravel.com | Phone: +91 98765 43210</p>

  <!-- Contact Info Boxes -->
  <div class="contact-cards">
    <div class="contact-card">
      <h3>Harini</h3>
      <p><strong>Phone:</strong> 9600765643</p>
      <p><strong>Email:</strong> harini4114@gmail.com</p>
    </div>
    
    <div class="contact-card">
      <h3>Eswari</h3>
      <p><strong>Phone:</strong> 987635222134</p>
      <p><strong>Email:</strong> eswari@gmail.com</p>
    </div>
    
    <div class="contact-card">
      <h3>Deepika</h3>
      <p><strong>Phone:</strong> 9876543210</p>
      <p><strong>Email:</strong> deepi@gmail.com</p>
    </div>
  </div>
</section>



<?php include('includes/footer.php'); ?>

<style>
  body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: url('images/home-bg.jpg') no-repeat center center fixed;
  background-size: cover;
  color: #fff;
}

.home-wrapper {
  background-color: rgba(0, 0, 0, 0.6);
  padding-bottom: 40px;
}

.section {
  padding: 40px 20px;
  text-align: center;
}

.review-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.review-card {
  background: rgba(255,255,255,0.9);
  padding: 15px;
  border-radius: 10px;
  width: 250px;
  color: #333;
  text-align: left;
}  


/*category css*/
.categories {
  background: linear-gradient(135deg, #fdfbfb, #ebedee);
  padding: 60px 20px;
}

.categories h2 {
  font-size: 32px;
  color: #333;
  margin-bottom: 30px;
  font-weight: 700;
}

.category-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 25px;
}

.category-card {
  background: linear-gradient(120deg, #a1c4fd, #c2e9fb);
  color: #333;
  padding: 20px 30px;
  border-radius: 20px;
  text-decoration: none;
  font-size: 18px;
  font-weight: 600;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
  background: linear-gradient(120deg, #89f7fe, #66a6ff);
  color: #000;
}


/*popular packages css*/
.popular {
  background: linear-gradient(to right, #e0eafc, #cfdef3);
  padding: 60px 20px;
}

.popular h2 {
  font-size: 32px;
  color: #222;
  margin-bottom: 30px;
  font-weight: 700;
  text-align: center;
}

.package-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: auto;
  padding: 10px;
}

.package-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 25px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: left;
  position: relative;
  overflow: hidden;
}

.package-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.package-card h3 {
  font-size: 22px;
  margin-bottom: 10px;
  color: #2c3e50;
}

.package-card p {
  margin-bottom: 10px;
  color: #555;
  font-size: 15px;
}

.package-card .price {
  color: #e67e22;
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 15px;
}

.btn-group {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.package-card .btn {
  flex: 1;
  padding: 10px;
  text-align: center;
  border-radius: 8px;
  font-weight: bold;
  text-decoration: none;
  transition: 0.3s ease;
  font-size: 14px;
}

.book-btn {
  background-color: #27ae60;
  color: white;
}

.book-btn:hover {
  background-color: #2ecc71;
}

.explore-btn {
  background-color: #2980b9;
  color: white;
}

.explore-btn:hover {
  background-color: #3498db;
}


/*contact css*/
.contact {
  background: #f0f0f0;
  padding: 60px 20px;
  text-align: center;
}

.contact h2 {
  font-size: 36px;
  font-weight: 700;
  color: #333;
  margin-bottom: 20px;
}

.contact p {
  font-size: 18px;
  margin-bottom: 40px;
  color: #555;
}

.contact-cards {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
}

.contact-card {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  width: 250px;
  text-align: center;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-card h3 {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 15px;
  color: #333;
}

.contact-card p {
  font-size: 16px;
  color: #555;
  margin-bottom: 10px;
}

.contact-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.contact-card p strong {
  color: #e67e22;
}


/*about css*/
/* About Section */
.about {
  background-color: #f0f8ff; /* Light blue background for a fresh look */
  padding: 40px 0; /* Reduced padding to make it less spacious */
  text-align: center;
}

/* About Wrapper */
.about-wrapper {
  width: 90%; /* Reduced width to make it more compact */
  margin: 0 auto;
  padding: 15px; /* Reduced padding */
}

/* About Content */
.about-content h2 {
  font-size: 2rem; /* Smaller font size */
  color: #333;
  font-weight: bold;
  margin-bottom: 15px; /* Reduced margin */
}

.about-content p {
  font-size: 1rem; /* Slightly smaller text */
  color: #555;
  line-height: 1.4; /* Reduced line height for a more compact text */
  margin-bottom: 15px; /* Reduced margin */
  font-family: 'Arial', sans-serif;
}

/* Team Section */
.about-team {
  margin-top: 30px; /* Reduced space above team section */
  padding-top: 15px; /* Reduced space */
  border-top: 2px solid #ddd;
}

.about-team h3 {
  font-size: 1.8rem; /* Slightly smaller heading */
  color: #333;
  font-weight: bold;
  margin-bottom: 20px; /* Reduced margin */
}

/* Team Members Container */
.team-members {
  display: flex;
  justify-content: space-evenly; /* Adjusted to use even spacing */
  flex-wrap: wrap;
  gap: 15px; /* Reduced gap */
}

/* Team Member */
.team-member {
  width: 220px; /* Reduced width */
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 15px; /* Reduced padding */
  text-align: center;
  transition: transform 0.3s ease-in-out;
}

.team-member img {
  width: 100%;
  height: 180px; /* Reduced height */
  object-fit: cover;
  border-radius: 10px;
  margin-bottom: 10px; /* Reduced margin */
}

.team-member h4 {
  font-size: 1.3rem; /* Reduced font size */
  color: #333;
  font-weight: 600;
  margin-bottom: 8px; /* Reduced margin */
}

.team-member p {
  font-size: 0.9rem; /* Smaller font size */
  color: #777;
}

/* Hover Effect for Team Members */
.team-member:hover {
  transform: translateY(-5px); /* Slightly reduced hover effect */
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
  .about-wrapper {
    width: 95%; /* Even smaller width on mobile */
  }

  .team-members {
    flex-direction: column;
    align-items: center;
  }

  .team-member {
    width: 80%; /* Occupy less space */
    margin-bottom: 15px; /* Reduced bottom margin */
  }
}




/*slideshow css*/
/* Background Wrapper */
.home-wrapper {
  position: relative;
  width: 100%;
  height: 100vh; /* Full screen height */
  overflow: hidden;
}

/* Slideshow Container */
.slideshow-container {
  position: relative;
  width: 100%;
  height: 75vh; /* Cover 3/4th of the screen */
  overflow: hidden;
}

.slide {
  display: none; /* Hide all slides initially */
  position: absolute;
  width: 100%;
  height: 100%;
}

.slide img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Ensures images cover the entire slide area */
}

/* Caption Styling */
.caption {
  position: absolute;
  bottom: 20px;
  left: 20px;
  font-size: 32px;
  color: white;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Shadow for readability */
  font-weight: bold;
  padding: 10px 20px;
  background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
  border-radius: 5px;
  z-index: 1;
}

/* Fade-in Animation */
@keyframes fade {
  0% { opacity: 0; }
  20% { opacity: 1; }
  80% { opacity: 1; }
  100% { opacity: 0; }
}

.fade {
  animation: fade 12s infinite;
}

/* Make each slide visible for 4 seconds */
.fade:nth-child(1) {
  animation-duration: 12s;
}

.fade:nth-child(2) {
  animation-duration: 12s;
  animation-delay: 4s; /* Slide 2 starts after 4 seconds */
}

.fade:nth-child(3) {
  animation-duration: 12s;
  animation-delay: 8s; /* Slide 3 starts after 8 seconds */
}

   


/* Apply Full Background Image */
body {
  background: url('images/background.jpg') no-repeat center center fixed;
  background-size: cover;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  color: #fff; /* Adjust text color for readability */
  overflow-x: hidden; /* Prevent horizontal scroll */
}

/* Section Styling */
.section {
  position: relative;
  padding: 80px 20px;
  text-align: center;
}

/* Slideshow Styling (Example) */
.slideshow {
  height: 500px;
  width: 100%;
  background: rgba(0, 0, 0, 0.5); /* Optional dark overlay for slideshow */
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}

.slideshow img {
  width: 100%;
  height: auto;
  object-fit: cover;
}

/* About Section */
.about {
  background-color: rgba(0, 0, 0, 0.6); /* Optional: dark overlay for contrast */
  padding: 100px 20px;
}

.about h2 {
  font-size: 48px;
  font-weight: bold;
  text-transform: uppercase;
}

.about p {
  font-size: 22px;
  max-width: 800px;
  margin: 0 auto;
  font-style: italic;
}

/* Popular Packages Section */
.popular-packages {
  background-color: rgba(0, 0, 0, 0.6); /* Optional: dark overlay for contrast */
  padding: 100px 20px;
}

.popular-packages h2 {
  font-size: 48px;
  font-weight: bold;
}

@media (max-width: 768px) {
  .about h2, .popular-packages h2 {
    font-size: 36px;
  }
  
  .about p, .popular-packages p {
    font-size: 18px;
  }
}


</style>  