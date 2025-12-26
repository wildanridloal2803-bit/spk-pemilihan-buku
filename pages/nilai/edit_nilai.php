<?php
include 'config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT * FROM nilai WHERE id_nilai='$id'
"));

if (isset($_POST['update'])) {
    $id_buku = $_POST['id_buku'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    $update = "UPDATE nilai SET id_buku='$id_buku', id_kriteria='$id_kriteria', nilai='$nilai' WHERE id_nilai='$id'";
    if (mysqli_query($koneksi, $update)) {
        header("Location: data_nilai.php");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">✏️ Edit Nilai Buku</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Judul Buku</label>
            <select name="id_buku" class="form-select" required>
                <?php
                $buku = mysqli_query($koneksi, "SELECT * FROM buku");
                while ($b = mysqli_fetch_assoc($buku)) {
                    $selected = ($b['id_buku'] == $data['id_buku']) ? 'selected' : '';
                    echo "<option value='{$b['id_buku']}' $selected>{$b['judul_buku']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Kriteria</label>
            <select name="id_kriteria" class="form-select" required>
                <?php
                $kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria");
                while ($k = mysqli_fetch_assoc($kriteria)) {
                    $selected = ($k['id_kriteria'] == $data['id_kriteria']) ? 'selected' : '';
                    echo "<option value='{$k['id_kriteria']}' $selected>{$k['nama_kriteria']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" value="<?= $data['nilai'] ?>" step="0.01" class="form-control" required>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="data_nilai.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
