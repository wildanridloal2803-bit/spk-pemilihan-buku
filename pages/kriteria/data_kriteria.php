<?php
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kriteria - SPK Buku Terlaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">⚙️ Data Kriteria Penilaian</h3>
    <a href="tambah_kriteria.php" class="btn btn-primary mb-3">+ Tambah Kriteria</a>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr align="center">
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr align="center">
                <td><?= $no++ ?></td>
                <td><?= $row['nama_kriteria'] ?></td>
                <td><?= $row['bobot'] ?></td>
                <td><?= ucfirst($row['tipe']) ?></td>
                <td>
                    <a href="edit_kriteria.php?id=<?= $row['id_kriteria'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_kriteria.php?id=<?= $row['id_kriteria'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../index.php" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
</div>
</body>
</html>
