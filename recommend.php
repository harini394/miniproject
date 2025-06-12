<?php
session_start();
include('includes/db_connect.php');
include('includes/header.php');


// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "⚠️ Please log in to view personalized recommendations.";
    exit;
}

// Fetch user preferences
$pref_query = "SELECT preferred_cat_id, budget FROM user_preferences WHERE user_id = ?";
$pref_stmt = $conn->prepare($pref_query);
$pref_stmt->bind_param("i", $user_id);
$pref_stmt->execute();
$pref_result = $pref_stmt->get_result();

if ($pref_result->num_rows > 0) {
    $pref = $pref_result->fetch_assoc();
    $preferred_cat_id = $pref['preferred_cat_id'];
    $budget = $pref['budget'];

    // Fetch matching packages
    $pkg_query = "SELECT * FROM package WHERE cat_id = ? AND price <= ?";
    $pkg_stmt = $conn->prepare($pkg_query);
    $pkg_stmt->bind_param("ii", $preferred_cat_id, $budget);
    $pkg_stmt->execute();
    $packages = $pkg_stmt->get_result();

    if ($packages->num_rows > 0) {
        echo "<h2>🎯 Recommended Packages for You</h2>";
        while ($row = $packages->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; padding:15px; margin:10px 0;'>";
            echo "<h3>" . htmlspecialchars($row['Package_name']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['Description']) . "</p>";
            echo "<p><strong>Price: ₹" . htmlspecialchars($row['Price']) . "</strong></p>";
            echo "</div>";
        }
    } else {
        echo "😕 No matching packages found for your preferences.";
    }
} else {
    echo "⚠️ Preferences not found. Please set your travel preferences first.";
}
?>
