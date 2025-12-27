<?php
// Tidak perlu include koneksi lagi karena sudah di-include oleh index.php

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO buku (judul_buku, penulis, harga, stok) 
              VALUES ('$judul', '$penulis', '$harga', '$stok')";
    
    if (mysqli_query($koneksi, $query)) {
        // Gunakan JS redirect agar aman di dalam index.php
        $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data buku baru berhasil ditambahkan';
        $_SESSION['icon'] = 'success';
    } else {
        $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
    }
}
?>

<div class="header-page" style="margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Tambah Buku</h2>
</div>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Judul Buku</label>
            <input type="text" name="judul_buku" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Penulis</label>
            <input type="text" name="penulis" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Harga (Rp)</label>
            <input type="number" name="harga" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Stok</label>
            <input type="number" name="stok" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <button type="submit" name="simpan" style="background: #1cc88a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            <i class="fas fa-save"></i> Simpan
        </button>
        
        <a href="index.php?page=data_buku" style="background: #858796; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 1rem;">
            Batal
        </a>
    </form>
</div>