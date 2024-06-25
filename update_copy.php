<?php 
require 'koneksi.php';

$hasil = mysqli_query($conn, 'SELECT * FROM geofence_coordinates');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data rumah sakit berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT id, latitude, longitude FROM geofence_coordinates WHERE id='$id'";
$result = $conn->query($sql);

$hospital = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];


    $sql = "UPDATE geofence_coordinates SET latitude='$latitude', longitude='$longitude' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data rumah sakit berhasil diperbarui!";
        header('Location: dataGeofancing.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Direktori Kantor Gubernur Kalbar</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        

        
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">Direktori</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Peta</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="data.php">Data</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    </div>
                </nav>

                <div class="container-fluid">
                    <h2>Update Rumah Sakit</h2>
                    <form action="update.php?id=<?php echo $hospital['id']; ?>" method="post">
                        <div class="form-group mb-3">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $hospital['latitude']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $hospital['longitude']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
