<?php
include('includes/db_connect.php');
include('includes/header.php');


// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to book a tour.'); window.location.href='index.php?page=login';</script>";
    exit();
}

$packid = $_GET['packid'] ?? '';
$packname = '';
$success = false;
$total_amount = 0;

// Get package name for Explore More button
if ($packid) {
    $stmt = $conn->prepare("SELECT Packname FROM package WHERE Packid = ?");
    $stmt->bind_param("i", $packid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $packname = $row['Packname'];
    }
    $stmt->close();
}

// Handle booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['user_id'];
    $package_id = $_POST['packid'];
    $adults = intval($_POST['adults']);
    $children = intval($_POST['children']);

    // Get package price
    $stmt = $conn->prepare("SELECT Price, Packname FROM package WHERE Packid = ?");
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $pkg = $res->fetch_assoc();
    $stmt->close();

    $price_per_person = $pkg['Price'];
    $packname = $pkg['Packname'];
    $total_amount = ($adults * $price_per_person) + ($children * $price_per_person * 0.5);

    // Insert into booking table with status as Confirmed
    $status = 'Confirmed';
    $insert = $conn->prepare("INSERT INTO booking (user_id, package_id, num_adults, num_children, total_price, status) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("iiiids", $userid, $package_id, $adults, $children, $total_amount, $status);
    $insert->execute();
    $insert->close();

    $success = true;
    $packid = $package_id;
}
?>

<div class="booking-form-container">
  <h2>Book Your Tour</h2>

  <?php if ($success): ?>
    <div class="success-message">
      ✅ Booking Confirmed! <br>
      💰 Total Price: ₹<?= number_format($total_amount, 2) ?>
    </div>
    <?php
      $search = explode(" in ", $packname);
      $destination = urlencode(end($search));
    ?>
   
  <?php else: ?>
    <form method="post" action="">
      <input type="hidden" name="selected_packid" value="<?= $packid ?>">

      <label>Select Package</label>
      <select name="packid" required>
        <option value="">-- Select Package --</option>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM package");
        while ($pkg = mysqli_fetch_assoc($query)) {
          $selected = ($pkg['Packid'] == $packid) ? 'selected' : '';
          echo "<option value='{$pkg['Packid']}' $selected>" . htmlspecialchars($pkg['Packname']) . "</option>";
        }
        ?>
      </select>

      <label>Number of Adults</label>
      <input type="number" name="adults" value="1" min="1" required>

      <label>Number of Children</label>
      <input type="number" name="children" value="0" min="0" required>

      <div style="margin-top: 20px;">
        <button type="submit" class="btn book-btn">Book Now</button>
      </div>
    </form>
  <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>

<style>
/* Full background image */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: url('images/booking.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    height: 100vh;
}
* Fixed Header */
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

/* Overlay for readability */
.booking-form-container {
    position: relative;
    z-index: 2;
    max-width: 600px;
    margin: 40px auto;
    background: rgba(0, 0, 0, 0.7); /* Dark semi-transparent background */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    text-align: center;
}

.booking-form-container h2 {
    font-size: 28px;
    color: #fff;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.booking-form-container form label {
    display: block;
    text-align: left;
    margin-top: 15px;
    font-weight: bold;
    font-size: 16px;
    color: #fff;
}

.booking-form-container form input,
.booking-form-container form select {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    color: #333;
}

.booking-form-container form input:focus,
.booking-form-container form select:focus {
    border-color: #007bff;
    outline: none;
}

.btn.book-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    width: 100%;
    margin-top: 20px;
    transition: background 0.3s ease;
}

.btn.book-btn:hover {
    background: #218838;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: bold;
}

/* Pop-up Styling */
.popup {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.popup h3 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #f44336;
}

.popup p {
    font-size: 18px;
    margin-bottom: 20px;
    color: #333;
}

.popup .btn {
    margin-top: 20px;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s;
}

.popup .btn:hover {
    background-color: #0056b3;
}

.popup-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #333;
    cursor: pointer;
}

.popup-close:hover {
    color: #f44336;
}

/* Show the popup */
.popup.show {
    display: flex;
    opacity: 1;
}

/* Transitions for smooth opening/closing of the pop-up */
.popup-content {
    transform: translateY(-30px);
    transition: transform 0.3s ease;
}

.popup.show .popup-content {
    transform: translateY(0);
}
</style>