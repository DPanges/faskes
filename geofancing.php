<?php
// Koneksi ke database
require 'koneksi.php';

$hasil = mysqli_query($conn, 'SELECT * FROM geofence_coordinates');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua koordinat dari database
$sql = "SELECT latitude, longitude FROM geofence_coordinates";
$result = $conn->query($sql);

$coordinates = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $coordinates[] = [$row['latitude'], $row['longitude']];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIGFASKES</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- leaflet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="leaflet-search-master\dist\leaflet-search.src.css">
    <link rel="stylesheet" href="jalan.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"</script>
    <script href="leaflet-search-master\dist\leaflet-search.src.js"></script>
    


    <!-- css -->
    <style>
        #map {
            height: 80vh;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">
                SIGFASKES
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Peta</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="data.php">Daftar
                    Faskes</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="geofancing.php">Titik Rawan</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="dataGeofancing.php">Data Titik Rawan</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        Toggle Menu
                    </button>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">
                        <h1 class="mt-4">Zona Rawan Kecelakaan</h1>
                    </div>
                </div>
                </div>

                <div id="map"></div>

            </div>
            
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.200000, 106.816666], 13); // Koordinat Jakarta

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Ambil koordinat dari PHP
        var coordinates = <?php echo json_encode($coordinates); ?>;

        // Tambahkan circle untuk setiap koordinat geofencing radius 0,5 km
        var marker = coordinates.map(function(coord) {
            var circle = L.circle([coord[0], coord[1]], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 500
            }).addTo(map);

        });

        // Fungsi untuk menghitung jarak menggunakan rumus Haversine
        function haversine(lat1, lon1, lat2, lon2) {
            function toRad(x) {
                return x * Math.PI / 180;
            }

            var R = 6371; // Radius bumi dalam kilometer
            var dLat = toRad(lat2 - lat1);
            var dLon = toRad(lon2 - lon1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            return d;
        }

        // Fungsi untuk memeriksa jarak ke setiap titik geofencing dan memberikan notifikasi
        function checkGeofence(lat, lng) {
            var distances = coordinates.map(function(coord) {
                return haversine(lat, lng, coord[0], coord[1]);
            });

            var minDistance = Math.min.apply(null, distances);

            if (minDistance < 0.5) { // jika jarak kurang dari 0,5 km
                alert("Anda berada dalam zona rawan kecelakaan. Jarak terdekat: " + minDistance.toFixed(2) + " km");
            } else {
                alert("Anda berada di luar  zona rawan kecelakaan. Jarak terdekat: " + minDistance.toFixed(2) + " km");
            }
        }


        // Fungsi untuk mendapatkan lokasi pengguna
        function onLocationFound(e) {
            var radius = e.accuracy / 2;

            L.marker(e.latlng).addTo(map)
                .bindPopup("Lokasi Anda Saat Ini").openPopup().addTo(map);

            checkGeofence(e.latlng.lat, e.latlng.lng);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        map.locate({setView: true, maxZoom: 16});
    </script>

</body>

</html>