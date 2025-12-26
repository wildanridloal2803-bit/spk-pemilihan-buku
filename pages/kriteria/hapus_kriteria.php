<?php
include 'config/koneksi.php';
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM kriteria WHERE id_kriteria='$id'");

if ($hapus) {
    header("Location: data_kriteria.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>
