<?php
// Pastikan koneksi sudah ada (karena di-include dari index.php)
// Jika diakses langsung, include koneksi
if (!isset($koneksi)) {
    include 'config/koneksi.php';
}

// --- LOGIKA PHP: MENGAMBIL DATA STATISTIK ---
// 1. Hitung Total Buku
$q_buku = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku");
$d_buku = mysqli_fetch_assoc($q_buku);
$total_buku = $d_buku['total'];

// 2. Hitung Total Kriteria
$q_kriteria = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kriteria");
$d_kriteria = mysqli_fetch_assoc($q_kriteria);
$total_kriteria = $d_kriteria['total'];

// 3. Ambil Juara 1 (Ranking Tertinggi)
$q_rank = mysqli_query($koneksi, "SELECT h.nilai_preferensi, b.judul_buku 
                                  FROM hasil h 
                                  JOIN buku b ON h.id_buku = b.id_buku 
                                  ORDER BY h.nilai_preferensi DESC LIMIT 1");
$juara = mysqli_fetch_assoc($q_rank);
$top_book = $juara ? $juara['judul_buku'] : "Belum Ada Data";

// 4. Data untuk Grafik (Judul vs Penjualan)
$labels_chart = "";
$data_chart   = "";
$q_grafik = mysqli_query($koneksi, "SELECT b.judul_buku, n.nilai 
                                    FROM nilai n 
                                    JOIN buku b ON n.id_buku = b.id_buku 
                                    WHERE n.id_kriteria = 1"); // Asumsi ID 1 adalah Penjualan
while($g = mysqli_fetch_assoc($q_grafik)){
    $labels_chart .= "'".$g['judul_buku']."',";
    $data_chart   .= $g['nilai'].",";
}
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary: #4e73df;
        --secondary: #858796;
        --success: #1cc88a;
        --info: #36b9cc;
        --warning: #f6c23e;
        --danger: #e74a3b;
        --dark: #5a5c69;
        --light: #f8f9fc;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    /* Reset & Base */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    
    body { background-color: #f3f4f6; color: #333; }

    /* Container Dashboard */
    .dashboard-container {
        padding: 20px;
        animation: fadeIn 0.8s ease-in-out;
    }

    /* Header Section */
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner h2 { font-size: 2rem; margin-bottom: 10px; }
    .welcome-banner p { opacity: 0.9; }
    
    /* Decoration Circles */
    .circle-deco {
        position: absolute;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .c1 { width: 100px; height: 100px; top: -20px; right: -20px; }
    .c2 { width: 150px; height: 150px; bottom: -50px; right: 40px; }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        border-left: 5px solid var(--primary);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .stat-info h5 { color: var(--secondary); font-size: 0.9rem; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
    .stat-info h3 { color: var(--dark); font-size: 1.8rem; font-weight: 700; }
    
    .stat-icon {
        font-size: 2.5rem;
        color: #dddfeb;
    }

    /* Colors for Borders */
    .border-blue { border-left-color: var(--primary); }
    .border-green { border-left-color: var(--success); }
    .border-orange { border-left-color: var(--warning); }

    /* Content Grid (Chart & Table) */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .chart-container, .top-list-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .content-grid { grid-template-columns: 1fr; }
        .welcome-banner h2 { font-size: 1.5rem; }
    }

    /* Animation Keyframes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="dashboard-container">
    
    <div class="welcome-banner">
        <div class="circle-deco c1"></div>
        <div class="circle-deco c2"></div>
        <h2>Halo, Admin Aliyah Agency! 👋</h2>
        <p>Selamat datang di Sistem Pendukung Keputusan Pemilihan Buku Terlaris (Metode SAW).</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card border-blue">
            <div class="stat-info">
                <h5>Data Buku</h5>
                <h3><?php echo $total_buku; ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
        </div>

        <div class="stat-card border-green">
            <div class="stat-info">
                <h5>Kriteria</h5>
                <h3><?php echo $total_kriteria; ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-list-check"></i>
            </div>
        </div>

        <div class="stat-card border-orange">
            <div class="stat-info">
                <h5>Rekomendasi #1</h5>
                <h3 style="font-size: 1.2rem;"><?php echo $top_book; ?></h3>
            </div>
            <div class="stat-icon">
                <i class="fas fa-crown text-warning"></i>
            </div>
        </div>
    </div>

    <div class="content-grid">
        
        <div class="chart-container">
            <h4 class="section-title"><i class="fas fa-chart-bar"></i> Statistik Penjualan Buku</h4>
            <canvas id="salesChart"></canvas>
        </div>

        <div class="top-list-container">
            <h4 class="section-title"><i class="fas fa-bolt"></i> Menu Cepat</h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="index.php?page=tambah_buku" style="text-decoration: none;">
                    <button style="width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                        <i class="fas fa-plus"></i> Tambah Buku Baru
                    </button>
                </a>
                <a href="index.php?page=hasil_saw" style="text-decoration: none;">
                    <button style="width: 100%; padding: 12px; background: var(--success); color: white; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                        <i class="fas fa-calculator"></i> Hitung SPK Sekarang
                    </button>
                </a>
                
                <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">
                
                <p style="font-size: 0.85rem; color: #888;">
                    <i class="fas fa-info-circle"></i> Pastikan semua nilai kriteria telah diisi sebelum melakukan perhitungan.
                </p>
            </div>
        </div>
    </div>

</div>

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

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $labels_chart; ?>], // Data dari PHP
            datasets: [{
                label: 'Jumlah Penjualan',
                data: [<?php echo $data_chart; ?>], // Data dari PHP
                backgroundColor: [
                    'rgba(78, 115, 223, 0.7)',
                    'rgba(28, 200, 138, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: "#f3f3f3" }
                },
                x: {
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>