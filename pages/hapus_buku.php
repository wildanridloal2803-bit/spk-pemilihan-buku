<?php
include '../config/koneksi.php';
$id = $_GET['id'];

$hapus = mysqli_query($conn, "DELETE FROM buku WHERE id_buku='$id'");

if ($hapus) {
    header("Location: data_buku.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
