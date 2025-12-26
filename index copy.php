<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>SPK Aliyah Agency - SAW</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #333; font-weight: bold; }
        nav { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
<body>

    <h1>Aliyah Agency - SPK Buku Terlaris</h1>
    
    <nav>
        <a href="index.php?page=home">Home</a>
        <a href="index.php?page=data_buku">Data Buku</a>
        <a href="index.php?page=data_kriteria">Kriteria</a>
        <a href="index.php?page=data_nilai">Input Nilai</a>
        <a href="index.php?page=hasil_saw">Hasil Perangkingan</a>
    </nav>

    <div class="content">
        <?php
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            switch ($page) {
                case 'data_buku': include 'pages/data_buku.php'; break;
                case 'data_kriteria': include 'pages/data_kriteria.php'; break;
                case 'data_nilai': include 'pages/data_nilai.php'; break;
                case 'hasil_saw': include 'pages/hasil_saw.php'; break;
                case 'tambah_buku': include 'pages/tambah_buku.php'; break;
                // Tambahkan case lain sesuai kebutuhan
                default: echo "<h3>Selamat Datang di Sistem Pendukung Keputusan</h3>";
            }
        } else {
            echo "<h3>Selamat Datang di Sistem Pendukung Keputusan</h3>";
        }
        ?>
    </div>

</body>
</html>