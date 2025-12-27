<div class="header-page" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Data Kriteria</h2>
    <a href="index.php?page=tambah_kriteria" style="background: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; transition: 0.3s;">
        <i class="fas fa-plus"></i> Tambah Kriteria
    </a>
</div>

<div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <table border="0" cellspacing="0" cellpadding="10" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fc; color: #5a5c69; text-align: center; border-bottom: 2px solid #e3e6f0;">
                <th style="padding: 15px;">No</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Variabel $koneksi otomatis tersedia dari index.php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
            
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){
            ?>
            <tr style="border-bottom: 1px solid #e3e6f0;">
                <td style="padding: 15px;" align="center"><?php echo $no++; ?></td>
                <td style="font-weight: 500; color: #4e73df;"><?php echo $row['nama_kriteria']; ?></td>
                <td align="center"><?php echo $row['bobot']; ?></td>
                <td align="center">
                    <?php 
                    if($row['tipe'] == 'benefit'){
                        echo '<span style="background:#1cc88a; color:white; padding:5px 10px; border-radius:15px; font-size:0.8rem;">Benefit</span>';
                    } else {
                        echo '<span style="background:#e74a3b; color:white; padding:5px 10px; border-radius:15px; font-size:0.8rem;">Cost</span>';
                    }
                    ?>
                </td>
                <td align="center">
                    <a href="index.php?page=edit_kriteria&id=<?php echo $row['id_kriteria']; ?>" style="color: #f6c23e; margin-right: 10px;" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?page=hapus_kriteria&id=<?php echo $row['id_kriteria']; ?>" style="color: #e74a3b;" title="Hapus" onclick="return confirm('Yakin ingin menghapus kriteria ini?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='5' align='center' style='padding: 20px; color: #858796;'>Belum ada data kriteria.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>