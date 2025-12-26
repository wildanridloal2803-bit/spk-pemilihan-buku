<?php error_reporting(E_ALL);
ini_set('display_errors', 1); include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SPK Buku Terlaris | Aliyah Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar-brand, .nav-link, .navbar-text {
            color: #fff !important;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">📚 SPK Buku Terlaris</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="pages/data_buku.php">Data Buku</a></li>
            <li class="nav-item"><a class="nav-link" href="pages/data_kriteria.php">Kriteria</a></li>
            <li class="nav-item"><a class="nav-link" href="pages/data_nilai.php">Nilai</a></li>
            <li class="nav-item"><a class="nav-link" href="pages/hasil_saw.php">Hasil SAW</a></li>
            <li class="nav-item"><a class="nav-link" href="pages/tentang.php">Tentang</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Sistem Pendukung Keputusan</h2>
            <p class="text-muted">Pemilihan Buku Terlaris di Aliyah Agency menggunakan Metode SAW (Simple Additive Weighting)</p>
        </div>

        <!-- Statistik Ringkas -->
        <div class="row g-4">
            <?php
            $totalBuku = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM buku"))['total'];
            $totalKriteria = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kriteria"))['total'];
            $totalNilai = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM nilai"))['total'];
            ?>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h4 class="text-primary">📖</h4>
                    <h5>Total Buku</h5>
                    <h3><?= $totalBuku ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h4 class="text-success">⚙️</h4>
                    <h5>Kriteria Penilaian</h5>
                    <h3><?= $totalKriteria ?></h3>
                </div>
            </div>
