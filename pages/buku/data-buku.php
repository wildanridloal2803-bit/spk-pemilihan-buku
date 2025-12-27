<div class="header-page" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Data Buku</h2>
    <a href="index.php?page=tambah_buku" style="background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; transition: 0.3s;">
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
            // $koneksi sudah otomatis ada dari index.php
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
                    <a href="index.php?page=edit_buku&id=<?php echo $row['id_buku']; ?>" style="color: #f6c23e; margin-right: 10px; text-decoration: none;" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?page=hapus_buku&id=<?php echo $row['id_buku']; ?>" style="color: #e74a3b; text-decoration: none;" title="Hapus" onclick="return confirm('Yakin ingin menghapus buku ini?');">
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