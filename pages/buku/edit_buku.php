<?php
include 'config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'"));

if (isset($_POST['update'])) {
    $judul = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $update = "UPDATE buku SET 
               judul_buku='$judul', penulis='$penulis', harga='$harga', stok='$stok' 
               WHERE id_buku='$id'";
    if (mysqli_query($koneksi, $update)) {
        header("Location: data_buku.php");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">✏️ Edit Data Buku</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Judul Buku</label>
            <input type="text" name="judul_buku" value="<?= $data['judul_buku'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" value="<?= $data['penulis'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $data['harga'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $data['stok'] ?>" class="form-control" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="data_buku.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
