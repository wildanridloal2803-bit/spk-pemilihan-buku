<?php
include 'config/koneksi.php';

// Simpan data baru
if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    $cek = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_buku='$id_buku' AND id_kriteria='$id_kriteria'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Nilai untuk kombinasi Buku dan Kriteria ini sudah ada!');</script>";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO nilai (id_buku, id_kriteria, nilai) VALUES ('$id_buku','$id_kriteria','$nilai')");
        if ($insert) {
            header("Location: data_nilai.php");
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">➕ Tambah Nilai Buku</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Judul Buku</label>
            <select name="id_buku" class="form-select" required>
                <option value="">-- Pilih Buku --</option>
                <?php
                $buku = mysqli_query($koneksi, "SELECT * FROM buku");
                while ($b = mysqli_fetch_assoc($buku)) {
                    echo "<option value='{$b['id_buku']}'>{$b['judul_buku']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Kriteria</label>
            <select name="id_kriteria" class="form-select" required>
                <option value="">-- Pilih Kriteria --</option>
                <?php
                $kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria");
                while ($k = mysqli_fetch_assoc($kriteria)) {
                    echo "<option value='{$k['id_kriteria']}'>{$k['nama_kriteria']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control" step="0.01" required>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="data_nilai.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
