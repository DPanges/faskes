<?php 
 // Koneksi ke database
$hostname = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";  // Ganti dengan password database Anda
$databasename = "geofencing";  // Ganti dengan nama database Anda

$conn = new mysqli($hostname, $username, $password, $databasename);