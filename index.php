<?php
// Koneksi database (di root)
include 'config/koneksi.php';

// Menangkap halaman yang diminta
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Aliyah Agency</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS Dashboard & Sidebar */
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #4e73df;
            --bg-color: #f8f9fc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-color); display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: white; position: fixed; height: 100vh; padding: 20px 0;
            z-index: 100; transition: all 0.3s ease;
        }
        .brand {
            text-align: center; font-size: 1.2rem; font-weight: 600; padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2); margin-bottom: 20px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .menu-item {
            display: block; padding: 15px 25px; color: rgba(255,255,255,0.8);
            text-decoration: none; transition: 0.3s; border-left: 4px solid transparent;
        }
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1); color: white; border-left-color: white;
        }
        .menu-header { font-size: 0.75rem; padding: 15px 25px 5px; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: bold; }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 30px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .brand span, .menu-item span, .menu-header { display: none; }
            .brand i { font-size: 1.5rem; }
            .menu-item { text-align: center; padding: 15px 0; }
            .menu-item i { margin: 0; font-size: 1.2rem; }
            .main-content { margin-left: 70px; width: calc(100% - 70px); }
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="brand">
            <i class="fas fa-book-open"></i> <span>Aliyah Agency</span>
        </div>

        <a href="index.php?page=home" class="menu-item <?php echo ($page == 'home') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>

        <div class="menu-header">Master Data</div>

        <a href="index.php?page=data_buku" class="menu-item <?php echo ($page == 'data_buku' || $page == 'tambah_buku' || $page == 'edit_buku') ? 'active' : ''; ?>">
            <i class="fas fa-book"></i> <span>Data Buku</span>
        </a>

        <a href="index.php?page=data_kriteria" class="menu-item <?php echo ($page == 'data_kriteria' || $page == 'tambah_kriteria') ? 'active' : ''; ?>">
            <i class="fas fa-list"></i> <span>Data Kriteria</span>
        </a>

        <div class="menu-header">SPK System</div>

        <a href="index.php?page=data_nilai" class="menu-item <?php echo ($page == 'data_nilai') ? 'active' : ''; ?>">
            <i class="fas fa-pen-to-square"></i> <span>Input Penilaian</span>
        </a>

        <a href="index.php?page=hasil_saw" class="menu-item <?php echo ($page == 'hasil_saw') ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i> <span>Hasil Perangkingan</span>
        </a>
    </nav>

    <main class="main-content">
        <?php
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            switch ($page) {
                // 1. DASHBOARD
                case 'home': include 'pages/dashboard.php'; break;
                
                // 2. MODUL BUKU (Folder: pages/buku/)
                // Perhatikan: di tree Anda namanya 'data-buku.php' (pakai strip)
                case 'data_buku': include 'pages/buku/data-buku.php'; break; 
                case 'tambah_buku': include 'pages/buku/tambah_buku.php'; break;
                case 'edit_buku': include 'pages/buku/edit_buku.php'; break;
                case 'hapus_buku': include 'pages/buku/hapus_buku.php'; break;

                // 3. MODUL KRITERIA (Folder: pages/kriteria/)
                case 'data_kriteria': include 'pages/kriteria/data_kriteria.php'; break;
                // Di tree Anda ada 2 file: tambah-kriteria.php DAN tambah_kriteria.php
                // Saya pakai yang underscore (_) agar konsisten, pastikan file yang dipakai benar.
                case 'tambah_kriteria': include 'pages/kriteria/tambah_kriteria.php'; break; 
                case 'edit_kriteria': include 'pages/kriteria/edit_kriteria.php'; break;
                case 'hapus_kriteria': include 'pages/kriteria/hapus_kriteria.php'; break;
                
                // 4. MODUL NILAI (Folder: pages/nilai/)
                case 'data_nilai': include 'pages/nilai/data_nilai.php'; break;
                case 'tambah_nilai': include 'pages/nilai/tambah_nilai.php'; break;
                case 'edit_nilai': include 'pages/nilai/edit_nilai.php'; break;
                case 'hapus_nilai': include 'pages/nilai/hapus_nilai.php'; break;
                
                // 5. HASIL SAW (Folder: pages/)
                case 'hasil_saw': include 'pages/hasil_saw.php'; break;
                
                default: include 'pages/dashboard.php';
            }
        } else {
            include 'pages/dashboard.php';
        }
        ?>
    </main>

</body>
</html>