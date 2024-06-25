<?php 
require 'koneksi.php';

if (isset($_POST['submit'])){
    echo 'submit';

    $nama = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $alamat = $_POST['address'];
    $telepon = $_POST['phone'];
    

    $hasil = mysqli_query($conn, "INSERT INTO hospitals VALUES ('', '$nama', '$latitude', '$longitude', '$alamat', '$telepon'  )");

    if(mysqli_affected_rows($conn) > 0){
        header('Location: data.php');
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
                    <h1>Tambah Data</h1>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label>Nama Faskes</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea type="text" name="address" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>No.HP</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
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
