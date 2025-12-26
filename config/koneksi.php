<?php
// Konfigurasi koneksi ke database
$host = "localhost";        // Nama host (biasanya localhost)
$user = "root";             // Username MySQL default XAMPP
$pass = "";                 // Password MySQL (kosong jika default)
$db   = "spk_buku_terlaris"; // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // Uncomment baris di bawah jika ingin menampilkan pesan sukses
    // echo "Koneksi berhasil!";
}
?>
