<?php
$host = "localhost";
$user = "root";
$pass = "123";
$db   = "spk-pemilihan-buku";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>