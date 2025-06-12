<?php
include('includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Please login to view booking history',
            showConfirmButton: true,
            confirmButtonText: 'Login Now'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?page=login';
            }
        });
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!-- FontAwesome & SweetAlert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Swipe Arrows -->
<div class="swipe-arrows">
    <a href="index.php?page=home" class="arrow left">&#8592; Home</a>
    <a href="index.php?page=packages" class="arrow right">Package &#8594;</a>
</div>

<!-- Booking Title -->
<h2 class="title">📜 Your Booking History</h2>

<style>
/* Add your styling here */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('images/bookinghistory.jpg') no-repeat center center fixed;
    background-size: cover;
    overflow-x: hidden;
}
.swipe-arrows {
    position: fixed;
    top: 20px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 30px;
    z-index: 999;
}
.arrow {
    color: white;
    font-size: 20px;
    background: rgba(0, 0, 0, 0.4);
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    transition: background 0.3s;
}
.arrow:hover {
    background: rgba(0, 0, 0, 0.7);
}
.title {
    text-align: center;
    margin-top: 80px;
    font-size: 36px;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
}
.booking-box {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    padding: 30px;
    margin: 30px auto;
    max-width: 800px;
    transition: transform 0.2s ease;
}
.booking-box:hover {
    transform: scale(1.02);
}
.booking-title {
    font-size: 24px;
    font-weight: bold;
    color: #2980b9;
    margin-bottom: 10px;
    border-bottom: 2px solid #ecf0f1;
    padding-bottom: 5px;
}
.booking-details {
    margin-top: 10px;
    font-size: 16px;
    color: #2c3e50;
    line-height: 1.8;
}
.booking-details i {
    color: #3498db;
    margin-right: 8px;
}
.place-type {
    background: #ecf9ff;
    border-left: 5px solid #007bff;
    margin-top: 20px;
    padding: 15px;
    border-radius: 8px;
}
.place-type span {
    font-weight: bold;
    font-size: 17px;
    color: #007bff;
}
.place-type small {
    color: #555;
}
.cancel-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 15px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s ease;
}
.cancel-btn:hover {
    background-color: #c0392b;
}
</style>

<?php
$stmt = $conn->prepare("
    SELECT b.*, p.Packname 
    FROM booking b 
    JOIN package p ON b.package_id = p.Packid 
    WHERE b.user_id = ? 
    ORDER BY b.booking_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()):
    $booking_id = $row['booking_id'];
    $packname = $row['Packname'];
?>

<div class="booking-box">
    <div class="booking-title"><?= htmlspecialchars($packname) ?></div>
    <div class="booking-details">
        <i class="fa fa-calendar"></i> Booking Date: <?= $row['booking_date'] ?><br>
        <i class="fa fa-user-friends"></i> Adults: <?= $row['num_adults'] ?> | Children: <?= $row['num_children'] ?><br>
        <i class="fa fa-rupee-sign"></i> Total Price: ₹<?= number_format($row['total_price'], 2) ?><br>
        <i class="fa fa-info-circle"></i> Status: <strong><?= $row['status'] ?></strong>
    </div>

    <?php if (strtolower($row['status']) !== 'cancelled'): ?>
        <form method="POST" action="index.php?page=cancel_booking" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
            <input type="hidden" name="booking_id" value="<?= $booking_id; ?>">
            <button type="submit" class="cancel-btn">
                <i class="fa fa-times-circle"></i> Cancel Booking
            </button>
        </form>
    <?php else: ?>
        <p style="margin-top: 15px; color: red; font-weight: bold;">
            <i class="fa fa-ban"></i> Booking Cancelled
        </p>
    <?php endif; ?>

    <?php
    $selection_stmt = $conn->prepare("SELECT * FROM user_selections WHERE user_id = ? AND packname = ? AND place_type IN ('hotel', 'restaurant', 'attraction')");
    $selection_stmt->bind_param("is", $user_id, $packname);
    $selection_stmt->execute();
    $selection_result = $selection_stmt->get_result();

    $selection_types = ['hotel' => [], 'restaurant' => [], 'attraction' => []];

    while ($selection = $selection_result->fetch_assoc()) {
        $type = strtolower($selection['place_type']);
        if (isset($selection_types[$type])) {
            $selection_types[$type][] = $selection;
        }
    }

    foreach ($selection_types as $type => $list):
        if (!empty($list)):
    ?>
    <div class="place-type">
        <span>Your Selected <?= ucfirst($type) ?><?= count($list) > 1 ? 's' : '' ?>:</span><br>
        <?php foreach ($list as $sel): ?>
            • <?= htmlspecialchars($sel['place_name']) ?> <small>(Saved on <?= date('d M Y', strtotime($sel['created_at'])) ?>)</small><br>
        <?php endforeach; ?>
    </div>
    <?php endif; endforeach; ?>
</div>

<?php endwhile; ?>
