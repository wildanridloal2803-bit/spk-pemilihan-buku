<?php
// Tidak perlu include koneksi karena sudah dari index.php
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id'");

if ($hapus) {
    $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data buku berhasil dihapus';
        $_SESSION['icon'] = 'success';
} else {
    $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
}
?>