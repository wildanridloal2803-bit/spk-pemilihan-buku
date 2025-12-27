<div class="header-page" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Data Nilai (Matrix)</h2>
    <a href="index.php?page=tambah_nilai" style="background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; transition: 0.3s;">
        <i class="fas fa-plus"></i> Tambah Nilai
    </a>
</div>

<div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <table border="0" cellspacing="0" cellpadding="10" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fc; color: #5a5c69; text-align: left; border-bottom: 2px solid #e3e6f0;">
                <th style="padding: 15px; text-align: center;">No</th>
                <th>Judul Buku</th>
                <th>Kriteria</th>
                <th>Nilai (Bobot)</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Join 3 tabel: Nilai -> Buku -> Kriteria
            $no = 1;
            $query = mysqli_query($koneksi, "
                SELECT n.id_nilai, b.judul_buku, k.nama_kriteria, n.nilai 
                FROM nilai n 
                JOIN buku b ON n.id_buku = b.id_buku 
                JOIN kriteria k ON n.id_kriteria = k.id_kriteria
                ORDER BY b.judul_buku ASC, k.id_kriteria ASC
            ");
            
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){
            ?>
            <tr style="border-bottom: 1px solid #e3e6f0;">
                <td style="padding: 15px;" align="center"><?php echo $no++; ?></td>
                <td style="font-weight: 500; color: #4e73df;"><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['nama_kriteria']; ?></td>
                <td><strong><?php echo $row['nilai']; ?></strong></td>
                <td align="center">
                    <a href="index.php?page=edit_nilai&id=<?php echo $row['id_nilai']; ?>" style="color: #f6c23e; margin-right: 10px;" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?page=hapus_nilai&id=<?php echo $row['id_nilai']; ?>" style="color: #e74a3b;" title="Hapus" onclick="return confirm('Yakin ingin menghapus nilai ini?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='5' align='center' style='padding: 20px; color: #858796;'>Belum ada data nilai.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>