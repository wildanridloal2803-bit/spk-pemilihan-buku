<?php
include 'config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $tipe = $_POST['tipe'];

    $query = "INSERT INTO kriteria (nama_kriteria, bobot, tipe) 
              VALUES ('$nama', '$bobot', '$tipe')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: data_kriteria.php");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">➕ Tambah Data Kriteria</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Bobot (0 - 1)</label>
            <input type="number" name="bobot" class="form-control" step="0.01" min="0" max="1" required>
        </div>
        <div class="mb-3">
            <label>Tipe Kriteria</label>
            <select name="tipe" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="benefit">Benefit</option>
                <option value="cost">Cost</option>
            </select>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="data_kriteria.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
