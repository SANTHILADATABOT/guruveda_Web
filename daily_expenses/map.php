<?php
// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and connect DB
session_start();
require_once("../model/config.inc.php");
require_once("../model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

// Get latitude & longitude from URL
$lat = isset($_GET['staff_latitude']) ? floatval($_GET['staff_latitude']) : 0;
$lng = isset($_GET['staff_longitude']) ? floatval($_GET['staff_longitude']) : 0;

// Default values
$company_name = "Unknown Location";
$address = "Address not found";

// Reverse geocode using OpenStreetMap (Nominatim)
if ($lat && $lng) {
    $geo_url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lng&format=json";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geo_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'GuruvedaMapApp/1.0'); // required by Nominatim
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);
        
        // Set address from display_name
        if (!empty($data['display_name'])) {
            $address = $data['display_name'];
        }

        // Set company name from most descriptive field
        if (!empty($data['address']['building'])) {
            $company_name = $data['address']['building'];
        } elseif (!empty($data['address']['commercial'])) {
            $company_name = $data['address']['commercial'];
        } elseif (!empty($data['address']['attraction'])) {
            $company_name = $data['address']['attraction'];
        } elseif (!empty($data['name'])) {
            $company_name = $data['name'];
        } elseif (!empty($data['address']['road'])) {
            $company_name = $data['address']['road'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($company_name); ?> Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
 <script>
    var lat = <?php echo json_encode($lat); ?>;
    var lng = <?php echo json_encode($lng); ?>;
    var address = <?php echo json_encode($address); ?>;

    // Create the map
    var map = L.map('map').setView([lat, lng], 17);

    // Base layer 1: Street view (OpenStreetMap)
    var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    });

    // Base layer 2: Satellite view (Esri)
    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/' +
        'World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '&copy; Esri, Maxar, Earthstar Geographics'
    });

    // Add default layer (street)
    streetLayer.addTo(map);

    // Add marker
    var marker = L.marker([lat, lng]).addTo(map)
        .bindPopup(address)
        .openPopup();

    // Base layers control
    var baseMaps = {
        "Street View": streetLayer,
        "Satellite View": satelliteLayer
    };

    L.control.layers(baseMaps).addTo(map);
</script>


</body>
</html>
