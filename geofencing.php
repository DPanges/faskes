<?php
require 'koneksi.php';

$hasil = mysqli_query($koneksi, 'SELECT * FROM tb_faskes');

$data = [];
while ($d = mysqli_fetch_assoc($hasil)) {
    $data[] = $d;
}

if (isset($_GET['method'])) {
    $method = $_GET['method'];
    $id = $_GET['id'];
    if ($method == 'hapus') {
        mysqli_query($koneksi, 'DELETE FROM tb_faskes WHERE id=' . $id);
        if (mysqli_affected_rows($koneksi) > 0) {
            header('Location: data.php');
        }
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
    <title>SIGRAWAN</title>
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
                SIGRAWAN
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Peta</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="data.php">Daftar
                    Faskes</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="geofancing.php">Titik Rawan</a>
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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">
                        <h1 class="mt-4">Peta</h1>
                    </div>
                    <div class="col-4">
                    <form>
                        <input  class="mt-4"s placeholder="Hitung Jarak" type="text" id="jarak" disabled>
                        <input class="mt-4" type="button" class="btn btn-primary" value="Hitung Jarak" onclick="hitungJarak()">
                    </form>
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
    <script src="js/scripts.js"></script>

    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            document.getElementById("demo").innerHTML =
                "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {

            var myIcon = L.icon({
                iconUrl: 'assets/user.png',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [-3, -36],
            });

            
            let data = <?php echo json_encode($data); ?>;
            console.log (data);
            data.map(function (d) {
                L.marker([d.latitude, d.longitude],{
                    icon : myIcon
                }).addTo(map).bindPopup(`
                <p>
                <i class="fa-solid fa-hospital"></i>
                    <b>Nama</b>: ${d.nama} 
                </p>
                <i class="fa-sharp fa-solid fa-map-pin"></i>
                    <b>Alamat</b>: ${d.alamat} 
                </p>
                <i class="fa-solid fa-phone"></i>
                    <b>Telepon</b>: ${d.telepon} 
                </p>
                `);

            });
        }
        var map = L.map('map').setView([0, 0], 16);
        

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);



        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        var markerA;
        var markerB;

        function onMapClick(e) {
            if (!markerA) {
                markerA = L.marker(e.latlng).addTo(map);
                $('#latlng1').val(e.latlng.lat + ',' + e.latlng.lng);
            } else if (!markerB) {
                markerB = L.marker(e.latlng).addTo(map);
                $('#latlng2').val(e.latlng.lat + ',' + e.latlng.lng);
            }
        }

        map.on('click', onMapClick);

        function hitungJarak() {
            if (markerA && markerB) {
                var latlng1 = markerA.getLatLng();
                var latlng2 = markerB.getLatLng();

                var R = 6371; // radius bumi dalam kilometer
                var dLat = (latlng2.lat - latlng1.lat) * Math.PI / 180;
                var dLon = (latlng2.lng - latlng1.lng) * Math.PI / 180;
                var a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(latlng1.lat * Math.PI / 180) * Math.cos(latlng2.lat * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c; // jarak dalam kilometer

                $('#jarak').val(d.toFixed(2) + ' km');
            } else {
                alert('Silahkan tambahkan titik A dan B pada peta');
            }
        } 

        // Geofance
        let userMarker, geofenceCenter, geofenceRadius;

        // Function initialize  map
        function initMap() {

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            // circle geofence
            geofenceCenter = L.latLng([0.373171, 108.946258]);
            L.circle(geofenceCenter).addTo(map).bindPopup('Titik Rawan Kecelakan');


            // radius 1000 = 1km
            geofenceRadius = 1000;

            // Start tracking the user's location
            map.locate({ watch: false, setView: true, maxZoom: 16 });

            // update lokasi
            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);
        }

        // update lokasi
        function onLocationFound(e) {
            const userLatLng = e.latlng;

            // update user marker
            if (!userMarker) {
                userMarker = L.marker(userLatLng).addTo(map);
            } else {
                userMarker.setLatLng(userLatLng);
            }

            // menghitung jarak geofence
            const distance = userLatLng.distanceTo(geofenceCenter);

            // Check if the user is inside the geofence
            if (distance <= geofenceRadius) {
                alert(`Kamu memasuki Zona Rawan Kecelakaan dengan jarak: ${distance.toFixed()} meter`);
            } else {
                alert(`Kamu diluar Zona Rawan Kecelakaan dengan jarak: ${distance.toFixed()} meters`);
            }
        }

        // lokasi error
        function onLocationError(e) {
            alert(e.message);
        }
        document.addEventListener('DOMContentLoaded', initMap);
    </script>

</body>

</html>