<<?php 
require 'koneksi.php';

$hasil = mysqli_query($conn, 'SELECT * FROM hospitals');

$data = [];
while ($d = mysqli_fetch_assoc($hasil)){
    $data[] = $d;
}

if (isset($_GET['method'])) {
    $method = $_GET['method'];
    $id = $_GET['id'];
    if ($method == 'hapus'){
        mysqli_query($conn, 'DELETE FROM hospitals WHERE id=' . $id);
        if (mysqli_affected_rows($conn) > 0){
            header('Location: data.php');
        }
    }
}


?>!DOCTYPE html>
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
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="data.php">Data Faskes</a>
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
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    </div>
                </nav>

                <div class="container-fluid">
                    <h1>Data</h1>
                    <a class="btn btn-primary" href="tambah.php">Tambah</a>
                    <div class="table-responsive">
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Latitude</th>
                            <th scope="col">Longitude</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No.HP</th>
                            <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php $no = 1; ?>
                            <?php foreach($data as $faskes) : ?>
                            <tr>
                                <th scope="row"><?= $no++; ?></th>
                                <td><?= $faskes['name'] ?></td>
                                <td><?= $faskes['latitude'] ?></td>
                                <td><?= $faskes['longitude'] ?></td>
                                <td><?= $faskes['address'] ?></td>
                                <td><?= $faskes['phone'] ?></td>
                                <td>
                                    <a  href="?id=<?= $faskes['id'] ?>&method=hapus" class="btn btn-danger">Hapus</a>
                                    <a class="btn btn-success" href="update.php?id=<?= $faskes['id'] ?>">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        </table>
                    </div>
                </div>
                

            </div>
        </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
