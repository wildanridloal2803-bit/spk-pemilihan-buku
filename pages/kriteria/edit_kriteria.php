<?php
include 'config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kriteria WHERE id_kriteria='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $tipe = $_POST['tipe'];

    $update = "UPDATE kriteria SET 
               nama_kriteria='$nama', bobot='$bobot', tipe='$tipe' 
               WHERE id_kriteria='$id'";
    if (mysqli_query($koneksi, $update)) {
        header("Location: data_kriteria.php");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">✏️ Edit Data Kriteria</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" value="<?= $data['nama_kriteria'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Bobot (0 - 1)</label>
            <input type="number" name="bobot" value="<?= $data['bobot'] ?>" step="0.01" min="0" max="1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipe Kriteria</label>
            <select name="tipe" class="form-select" required>
                <option value="benefit" <?= $data['tipe'] == 'benefit' ? 'selected' : '' ?>>Benefit</option>
                <option value="cost" <?= $data['tipe'] == 'cost' ? 'selected' : '' ?>>Cost</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="data_kriteria.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
