<?php
// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil data buku berdasarkan ID
$data_buku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'"));

if (isset($_POST['update'])) {
    $judul = $_POST['judul_buku'];
    $penulis = $_POST['penulis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $update = "UPDATE buku SET 
               judul_buku='$judul', penulis='$penulis', harga='$harga', stok='$stok' 
               WHERE id_buku='$id'";
               
    if (mysqli_query($koneksi, $update)) {
        $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data buku berhasil diupdate';
        $_SESSION['icon'] = 'success';
    } else {
        $_SESSION['status'] = 'Gagal!';
        $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
        $_SESSION['icon'] = 'error';
    }
}
?>

<div class="header-page" style="margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Edit Buku</h2>
</div>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Judul Buku</label>
            <input type="text" name="judul_buku" value="<?= $data_buku['judul_buku'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Penulis</label>
            <input type="text" name="penulis" value="<?= $data_buku['penulis'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Harga (Rp)</label>
            <input type="number" name="harga" value="<?= $data_buku['harga'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Stok</label>
            <input type="number" name="stok" value="<?= $data_buku['stok'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <button type="submit" name="update" style="background: #f6c23e; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            <i class="fas fa-save"></i> Update Data
        </button>
        
        <a href="index.php?page=data_buku" style="background: #858796; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 1rem;">
            Batal
        </a>
    </form>
</div>