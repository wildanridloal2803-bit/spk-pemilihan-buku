<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $tipe = $_POST['tipe'];

    $query = "INSERT INTO kriteria (nama_kriteria, bobot, tipe) 
              VALUES ('$nama', '$bobot', '$tipe')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data kriteria baru berhasil ditambahkan';
        $_SESSION['icon'] = 'success';
    } else {
       $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
        
        echo "<script>window.location.href='index.php?page=data_kriteria';</script>";
    }
}
?>

<div class="header-page" style="margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Tambah Kriteria</h2>
</div>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Nama Kriteria</label>
            <input type="text" name="nama_kriteria" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Bobot (0 - 1)</label>
            <input type="number" name="bobot" step="0.01" min="0" max="1" placeholder="Contoh: 0.5" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Tipe Kriteria</label>
            <select name="tipe" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                <option value="">-- Pilih Tipe --</option>
                <option value="benefit">Benefit (Semakin besar semakin bagus)</option>
                <option value="cost">Cost (Semakin kecil semakin bagus)</option>
            </select>
        </div>
        
        <button type="submit" name="simpan" style="background: #1cc88a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            <i class="fas fa-save"></i> Simpan
        </button>
        
        <a href="index.php?page=data_kriteria" style="background: #858796; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 1rem;">
            Batal
        </a>
    </form>
</div>