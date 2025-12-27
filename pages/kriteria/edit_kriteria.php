<?php
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kriteria WHERE id_kriteria='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $tipe = $_POST['tipe'];

    $update = "UPDATE kriteria SET 
               nama_kriteria='$nama', bobot='$bobot', tipe='$tipe' 
               WHERE id_kriteria='$id'";
    
    if (mysqli_query($koneksi, $update)) {
         $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data kriteria berhasil diupdate';
        $_SESSION['icon'] = 'success';
    } else {
        $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
    }
}
?>

<div class="header-page" style="margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Edit Kriteria</h2>
</div>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Nama Kriteria</label>
            <input type="text" name="nama_kriteria" value="<?= $data['nama_kriteria'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Bobot (0 - 1)</label>
            <input type="number" name="bobot" value="<?= $data['bobot'] ?>" step="0.01" min="0" max="1" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Tipe Kriteria</label>
            <select name="tipe" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                <option value="benefit" <?= $data['tipe'] == 'benefit' ? 'selected' : '' ?>>Benefit</option>
                <option value="cost" <?= $data['tipe'] == 'cost' ? 'selected' : '' ?>>Cost</option>
            </select>
        </div>
        
        <button type="submit" name="update" style="background: #f6c23e; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            <i class="fas fa-save"></i> Update
        </button>
        
        <a href="index.php?page=data_kriteria" style="background: #858796; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 1rem;">
            Batal
        </a>
    </form>
</div>