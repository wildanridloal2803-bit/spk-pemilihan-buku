<div class="header-page" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Data Buku</h2>
    <a href="index.php?page=tambah_buku" style="background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 0.9rem;">
        <i class="fas fa-plus"></i> Tambah Data
    </a>
</div>

<div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <table border="0" cellspacing="0" cellpadding="10" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fc; color: #5a5c69; text-align: left; border-bottom: 2px solid #e3e6f0;">
                <th style="padding: 15px;">No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menggunakan variabel global $koneksi dari index.php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
            
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){
            ?>
            <tr style="border-bottom: 1px solid #e3e6f0;">
                <td style="padding: 15px;"><?php echo $no++; ?></td>
                <td style="font-weight: 500; color: #4e73df;"><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['penulis']; ?></td>
                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?php echo $row['stok']; ?> pcs</td>
                <td align="center">
                    <a href="index.php?page=edit_buku&id=<?php echo $row['id_buku']; ?>" style="color: #f6c23e; margin-right: 10px;" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?page=hapus_buku&id=<?php echo $row['id_buku']; ?>" style="color: #e74a3b;" title="Hapus" onclick="return confirm('Yakin ingin menghapus buku ini?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='6' align='center' style='padding: 20px; color: #858796;'>Belum ada data buku.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- <?php
include 'config/koneksi.php';
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
            $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
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
</html> -->
