<?php
require 'koneksi.php';

$hasil = mysqli_query($conn, 'SELECT * FROM hospitals');

// Ambil semua koordinat rumah sakit dari database
$sql = "SELECT id, name, latitude, longitude, address, phone FROM hospitals";
$result = $conn->query($sql);

$hospitals = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $hospitals[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'address' => $row['address'],
            'phone' => $row['phone']
        ];
    }
}

if (isset($_GET['method'])) {
    $method = $_GET['method'];
    $id = $_GET['id'];
    if ($method == 'hapus') {
        mysqli_query($koneksi, 'DELETE FROM hospitals WHERE id=' . $id);
        if (mysqli_affected_rows($conn) > 0) {
            header('Location: data.php');
        }
    }
}


$conn->close();

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

        #search {
            margin: 20px 0;
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
                <button class="btn btn-primary" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
            </div>
            </nav>
            <!-- Page content-->
            <div id="search">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari rumah sakit..." onkeyup="searchHospital()">
        </div>

                <div id="map"></div>

            </div>
            
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.200000, 106.816666], 13); // Koordinat Jakarta

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);



        // Ambil koordinat rumah sakit dari PHP
        var hospitals = <?php echo json_encode($hospitals); ?>;

        // Tambahkan marker untuk setiap rumah sakit
        var hospitalMarkers = hospitals.map(function(hospital) {
            var marker = L.marker([hospital.latitude, hospital.longitude])
                .bindPopup(
                    "<b>" + hospital.name + "</b><br>" +
                    "Alamat: " + hospital.address + "<br>" +
                    "Telepon: " + hospital.phone
                )
                .addTo(map);
            return marker;
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

        // Fungsi untuk memeriksa jarak ke rumah sakit dan memberikan notifikasi
        function checkDistance(lat, lng) {
            var distances = hospitals.map(function(hospital) {
                return {
                    name: hospital.name,
                    distance: haversine(lat, lng, hospital.latitude, hospital.longitude)
                };
            });

            distances.sort(function(a, b) {
                return a.distance - b.distance;
            });

            var closestHospital = distances[0];
            alert("Rumah sakit terdekat: " + closestHospital.name + ". Jarak: " + closestHospital.distance.toFixed(2) + " km");

            return closestHospital;
        }

        // Fungsi untuk memperbarui lokasi pengguna
        var userMarker, userCircle, routeControl;
        function updateLocation(latlng) {
            if (userMarker) {
                map.removeLayer(userMarker);
            }
            if (routeControl) {
                map.removeControl(routeControl);
            }

            userMarker = L.marker(latlng).addTo(map)
                .bindPopup("Lokasi Anda saat ini").openPopup().addTo(map);

            var closestHospital = checkDistance(latlng.lat, latlng.lng);

            // Menambahkan rute menuju rumah sakit terdekat
            routeControl = L.Routing.control({
                waypoints: [
                    L.latLng(latlng.lat, latlng.lng),
                    L.latLng(hospitals.find(h => h.name === closestHospital.name).latitude, hospitals.find(h => h.name === closestHospital.name).longitude)
                ],
                routeWhileOnClick: true
            }).addTo(map);
        }

        // Fungsi untuk mendapatkan lokasi pengguna
        function onLocationFound(e) {
            updateLocation(e.latlng);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        map.locate({watch: true, setView: true, maxZoom: 16, enableHighAccuracy: true});

        // Fungsi untuk mencari rumah sakit
        function searchHospital() {
            var input = document.getElementById('searchInput').value.toLowerCase();
            var foundHospital = hospitals.find(function(hospital) {
                return hospital.name.toLowerCase().includes(input);
            });

            if (foundHospital) {
                var latlng = L.latLng(foundHospital.latitude, foundHospital.longitude);
                map.setView(latlng, 15);
                if (routeControl) {
                    map.removeControl(routeControl);
                }
                L.popup()
                    .setLatLng(latlng)
                    .setContent(
                        "<b>" + foundHospital.name + "</b><br>" +
                        "Alamat: " + foundHospital.address + "<br>" +
                        "Telepon: " + foundHospital.phone
                    )
                    .openOn(map);
            }
        }
    </script>

    

</body>

</html>