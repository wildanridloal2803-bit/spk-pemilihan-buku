<?php
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM kriteria WHERE id_kriteria='$id'");

if ($hapus) {
    $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data kriteria berhasil dihapus';
        $_SESSION['icon'] = 'success';
} else {
    $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
}
?>