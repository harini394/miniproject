<?php
include('includes/header.php');
?>
<section class="about-section">
  <h1>About Us</h1>
  <p>Welcome to <strong>Tours & Travel</strong> – your trusted partner in crafting unforgettable journeys. With a passion for exploration and a commitment to excellence, we specialize in providing handpicked travel experiences that cater to every kind of traveler, from adventurers and nature lovers to families and honeymooners.</p>
  
  <p>Our mission is simple: <em>to turn your travel dreams into reality</em>. We believe that travel is not just about reaching a destination – it's about the experiences, the stories, and the memories you create along the way. That’s why we offer a wide range of carefully curated tour packages, exceptional customer service, and seamless travel planning.</p>

  <p>We collaborate with top-rated local guides, hotels, and transport services to ensure your comfort, safety, and satisfaction. Whether you're looking to explore the tranquil mountains, relax on sun-kissed beaches, or uncover the hidden gems of urban life – we’ve got you covered.</p>

  <p>Join thousands of happy travelers who trust us to plan their getaways. Let’s discover the world together, one beautiful destination at a time.</p>

  <div class="team-section">
    <h2>Meet Our Team</h2>
    <div class="team-member">
      <h3>David Miller – Founder & Travel Enthusiast</h3>
      <p>David brings over a decade of experience in the travel industry, leading the vision behind our unforgettable packages.</p>
    </div>
    <div class="team-member">
      <h3>Sophia Lee – Customer Experience Manager</h3>
      <p>Sophia ensures every traveler’s journey is smooth, enjoyable, and personalized to their needs.</p>
    </div>
  </div>
</section>

<?php include('includes/footer.php'); ?>


<style>
 /* Full Page Background */
 body {
  background-image: url('images/about.jpg'); /* Replace with your desired background image */
  background-size: cover;
  background-position: center center;
  background-attachment: fixed; /* Makes the background fixed on scroll */
  color: #fff; /* Default text color */
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
}
/* Reset some basic styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Fixed Header */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 70px;
  background-color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 30px;
}

header .logo {
  font-size: 24px;
  font-weight: bold;
  color: #0077cc;
}

header nav a {
  margin-left: 20px;
  text-decoration: none;
  color: #333;
  font-weight: 500;
}

header nav a:hover {
  color: #0077cc;
}

/* Main Content Below Header */
main {
  padding-top: 100px; /* Enough to clear the fixed header */
  padding-left: 30px;
  padding-right: 30px;
}

/* About Section */
.about-section {
  background-color: #fff;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

.about-section h1 {
  font-size: 36px;
  margin-bottom: 20px;
  color: #0077cc;
}

.about-section p {
  font-size: 18px;
  color: #555;
  line-height: 1.8;
}
</style>