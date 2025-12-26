<?php
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Nilai - SPK Buku Terlaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">🧮 Data Nilai Penilaian Buku</h3>
    <a href="tambah_nilai.php" class="btn btn-primary mb-3">+ Tambah Nilai</a>
    <table class="table table-bordered table-striped">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Kriteria</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "
                SELECT n.id_nilai, b.judul_buku, k.nama_kriteria, n.nilai 
                FROM nilai n 
                JOIN buku b ON n.id_buku = b.id_buku 
                JOIN kriteria k ON n.id_kriteria = k.id_kriteria
                ORDER BY b.id_buku, k.id_kriteria
            ");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr class="text-center">
                <td><?= $no++ ?></td>
                <td><?= $row['judul_buku'] ?></td>
                <td><?= $row['nama_kriteria'] ?></td>
                <td><?= $row['nilai'] ?></td>
                <td>
                    <a href="edit_nilai.php?id=<?= $row['id_nilai'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_nilai.php?id=<?= $row['id_nilai'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../index.php" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
</div>
</body>
</html>
