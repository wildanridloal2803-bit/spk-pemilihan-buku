<?php
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_nilai='$id'"));

if (isset($_POST['update'])) {
    $id_buku = $_POST['id_buku'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    $update = "UPDATE nilai SET id_buku='$id_buku', id_kriteria='$id_kriteria', nilai='$nilai' WHERE id_nilai='$id'";
    
    if (mysqli_query($koneksi, $update)) {
       $_SESSION['status'] = 'Berhasil!';
        $_SESSION['pesan'] = 'Data nilai berhasil diupdate';
        $_SESSION['icon'] = 'success';
    } else {
         $_SESSION['status'] = 'Gagal!';
         $_SESSION['pesan'] = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
         $_SESSION['icon'] = 'error';
    }
}
?>

<div class="header-page" style="margin-bottom: 20px;">
    <h2 style="color: #4e73df; font-weight: 600;">Edit Nilai</h2>
</div>

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
    <form method="POST">
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Judul Buku</label>
            <select name="id_buku" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                <?php
                $buku = mysqli_query($koneksi, "SELECT * FROM buku");
                while ($b = mysqli_fetch_assoc($buku)) {
                    $selected = ($b['id_buku'] == $data['id_buku']) ? 'selected' : '';
                    echo "<option value='{$b['id_buku']}' $selected>{$b['judul_buku']}</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Kriteria</label>
            <select name="id_kriteria" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                <?php
                $kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria");
                while ($k = mysqli_fetch_assoc($kriteria)) {
                    $selected = ($k['id_kriteria'] == $data['id_kriteria']) ? 'selected' : '';
                    echo "<option value='{$k['id_kriteria']}' $selected>{$k['nama_kriteria']}</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; color: #5a5c69;">Nilai</label>
            <input type="number" name="nilai" value="<?= $data['nilai'] ?>" step="0.01" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <button type="submit" name="update" style="background: #f6c23e; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
            <i class="fas fa-save"></i> Update
        </button>
        
        <a href="index.php?page=data_nilai" style="background: #858796; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px; font-size: 1rem;">
            Batal
        </a>
    </form>
</div>