<?php
if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    // Cek apakah kombinasi Buku + Kriteria ini sudah ada?
    $cek = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_buku='$id_buku' AND id_kriteria='$id_kriteria'");
    
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Error: Nilai untuk Buku dan Kriteria tersebut sudah ada! Silakan edit data yang lama.');</script>";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO nilai (id_buku, id_kriteria, nilai) VALUES ('$id_buku','$id_kriteria','$nilai')");
        
        if ($insert) {
           $_SESSION['status'] = 'Berhasil!';
            $_SESSION['pesan'] = 'Data nilai baru berhasil ditambahkan';
            $_SESSION['icon'] = 'success';
        } else {
                $_SESSION['status'] = 'Gagal!';
                $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
                $_SESSION['icon'] = 'error';
        }
    }
}
?>

<div class="header-page" style="margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Tambah Nilai</h2>
</div>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST">
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Pilih Buku</label>
            <select name="id_buku" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                <option value="">-- Pilih Buku --</option>
                <?php
                $buku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY judul_buku ASC");
                while ($b = mysqli_fetch_assoc($buku)) {
                    echo "<option value='{$b['id_buku']}'>{$b['judul_buku']}</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Pilih Kriteria</label>
            <select name="id_kriteria" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                <option value="">-- Pilih Kriteria --</option>
                <?php
                $kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY nama_kriteria ASC");
                while ($k = mysqli_fetch_assoc($kriteria)) {
                    echo "<option value='{$k['id_kriteria']}'>{$k['nama_kriteria']}</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Nilai (Angka)</label>
            <input type="number" name="nilai" step="0.01" required placeholder="Contoh: 80" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <button type="submit" name="simpan" style="background: #1cc88a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            <i class="fas fa-save"></i> Simpan
        </button>
        
        <a href="index.php?page=data_nilai" style="background: #858796; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 1rem;">
            Batal
        </a>
    </form>
</div>