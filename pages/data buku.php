<?php
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku - SPK Buku Terlaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="fw-bold text-primary mb-3">📚 Data Buku</h3>
    <a href="tambah_buku.php" class="btn btn-primary mb-3">+ Tambah Buku</a>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr align="center">
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td align="center"><?= $no++ ?></td>
                <td><?= $row['judul_buku'] ?></td>
                <td><?= $row['penulis'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td align="center"><?= $row['stok'] ?></td>
                <td align="center">
                    <a href="edit_buku.php?id=<?= $row['id_buku'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_buku.php?id=<?= $row['id_buku'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../index.php" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
</div>
</body>
</html>
