<?php
include 'config/koneksi.php';
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM nilai WHERE id_nilai='$id'");

if ($hapus) {
    header("Location: data_nilai.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>
