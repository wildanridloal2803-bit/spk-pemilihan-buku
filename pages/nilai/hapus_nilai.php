<?php
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM nilai WHERE id_nilai='$id'");

if ($hapus) {
        $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data nilai berhasil dihapus';
        $_SESSION['icon'] = 'success';
} else {
        $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
}
?>