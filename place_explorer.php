<?php
include('includes/db_connect.php');
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href = 'index.php?page=login';</script>";
    exit;
}

$packname = $_GET['packname'] ?? '';
$placeName = $_GET['place'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_places'])) {
    $user_id = $_SESSION['user_id'];
    $selected = $_POST['selected_places'];

    $stmt = $conn->prepare("INSERT INTO user_selections (user_id, place_name, place_type, packname) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    foreach ($selected as $item) {
        list($place_name, $place_type) = explode('|', $item);
        $stmt->bind_param("isss", $user_id, $place_name, $place_type, $packname);
        $stmt->execute();
    }

    echo "<script>alert('✅ Places confirmed for $packname! Proceed to Booking.'); window.location.href = 'index.php?page=booking&packname=" . urlencode($packname) . "';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Explore <?php echo htmlspecialchars($placeName); ?></title>
    <link rel="stylesheet" href="css/place_explorer.css">
</head>
<body>
    <div class="explorer-container">
        <h2>Explore & Choose Places for <span class="highlight"><?php echo htmlspecialchars($packname); ?></span></h2>

        <form method="POST">
            <input type="hidden" name="packname" value="<?php echo htmlspecialchars($packname); ?>">

            <div id="map" style="height: 400px; border-radius: 12px;"></div>

            <div class="place-list">
                <h3>Pick Restaurants, Attractions & Hotel:</h3>
                <ul id="results"></ul>
            </div>

            <button type="submit" class="confirm-btn">➜ Confirm Booking</button>
        </form>
    </div>

    <!-- Leaflet and Overpass logic -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        const placeName = "<?php echo addslashes($placeName); ?>";
        const map = L.map('map').setView([20.5937, 78.9629], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        async function searchNearby(query, type) {
            const url = `https://overpass-api.de/api/interpreter?data=[out:json];node(around:3000,${map.getCenter().lat},${map.getCenter().lng})[${query}];out;`;
            const res = await fetch(url);
            const data = await res.json();

            data.elements.slice(0, 5).forEach(place => {
                const name = place.tags.name || 'Unnamed';
                const lat = place.lat;
                const lon = place.lon;

                const label = `${name} (${type})`;
                const value = `${name}|${type}`;

                // Add to list
                const li = document.createElement('li');
                li.innerHTML = `<input type="checkbox" name="selected_places[]" value="${value}"> ${label}`;
                document.getElementById('results').appendChild(li);

                // Add to map
                L.marker([lat, lon]).addTo(map).bindPopup(label);
            });
        }

        // Center map to searched place
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${placeName}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const lat = data[0].lat;
                    const lon = data[0].lon;
                    map.setView([lat, lon], 14);

                    searchNearby('amenity=restaurant', 'Restaurant');
                    searchNearby('tourism=attraction', 'Attraction');
                    searchNearby('tourism=hotel', 'Hotel');
                }
            });
    </script>
</body>
</html>


<style>
    body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f8fc;
    margin: 0;
    padding: 20px;
}

.explorer-container {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #2d89ef;
    margin-bottom: 10px;
}

.highlight {
    color: #1e5fab;
}

.place-list h3 {
    margin-top: 30px;
    color: #333;
}

ul#results {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}

ul#results li {
    background: #f0f0f0;
    margin-bottom: 8px;
    padding: 10px;
    border-radius: 12px;
    font-size: 15px;
}

.confirm-btn {
    display: block;
    margin: 25px auto 0;
    background: #2d89ef;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s ease;
}

.confirm-btn:hover {
    background: #1b5bbf;
}
</style>