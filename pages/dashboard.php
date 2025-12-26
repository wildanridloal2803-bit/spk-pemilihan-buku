<?php
// Pastikan koneksi sudah ada
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

// 4. Data untuk Grafik
$labels_chart = "";
$data_chart   = "";
// Pastikan ID Kriteria 1 benar-benar 'Jumlah Penjualan' di database Anda
$q_grafik = mysqli_query($koneksi, "SELECT b.judul_buku, n.nilai 
                                    FROM nilai n 
                                    JOIN buku b ON n.id_buku = b.id_buku 
                                    WHERE n.id_kriteria = 1"); 
while($g = mysqli_fetch_assoc($q_grafik)){
    $labels_chart .= "'".$g['judul_buku']."',";
    $data_chart   .= $g['nilai'].",";
}
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Styling Dashboard (Sama seperti sebelumnya) */
    :root {
        --primary: #4e73df; --secondary: #858796; --success: #1cc88a;
        --warning: #f6c23e; --danger: #e74a3b; --dark: #5a5c69;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { background-color: #f3f4f6; color: #333; }
    .dashboard-container { padding: 20px; animation: fadeIn 0.8s ease-in-out; }
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px;
        box-shadow: var(--card-shadow); position: relative; overflow: hidden;
    }
    .welcome-banner h2 { font-size: 2rem; margin-bottom: 10px; }
    .circle-deco { position: absolute; background: rgba(255,255,255,0.1); border-radius: 50%; }
    .c1 { width: 100px; height: 100px; top: -20px; right: -20px; }
    .c2 { width: 150px; height: 150px; bottom: -50px; right: 40px; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card {
        background: white; padding: 25px; border-radius: 12px;
        border-left: 5px solid var(--primary); box-shadow: var(--card-shadow);
        transition: transform 0.3s ease; display: flex; justify-content: space-between; align-items: center;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-info h5 { color: var(--secondary); font-size: 0.9rem; text-transform: uppercase; }
    .stat-info h3 { font-size: 1.8rem; font-weight: 700; color: var(--dark); }
    .stat-icon { font-size: 2.5rem; color: #dddfeb; }
    .border-blue { border-left-color: var(--primary); }
    .border-green { border-left-color: var(--success); }
    .border-orange { border-left-color: var(--warning); }
    .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    .chart-container, .top-list-container { background: white; padding: 20px; border-radius: 12px; box-shadow: var(--card-shadow); }
    .section-title { font-size: 1.1rem; font-weight: 600; color: var(--primary); margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    @media (max-width: 768px) { .content-grid { grid-template-columns: 1fr; } }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
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
            <div class="stat-icon"><i class="fas fa-book"></i></div>
        </div>

        <div class="stat-card border-green">
            <div class="stat-info">
                <h5>Kriteria</h5>
                <h3><?php echo $total_kriteria; ?></h3>
            </div>
            <div class="stat-icon"><i class="fas fa-list-check"></i></div>
        </div>

        <div class="stat-card border-orange">
            <div class="stat-info">
                <h5>Rekomendasi #1</h5>
                <h3 style="font-size: 1.2rem;"><?php echo $top_book; ?></h3>
            </div>
            <div class="stat-icon"><i class="fas fa-crown text-warning"></i></div>
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
                    <button style="width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="fas fa-plus"></i> Tambah Buku Baru
                    </button>
                </a>
                <a href="index.php?page=hasil_saw" style="text-decoration: none;">
                    <button style="width: 100%; padding: 12px; background: var(--success); color: white; border: none; border-radius: 8px; cursor: pointer;">
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

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $labels_chart; ?>],
            datasets: [{
                label: 'Jumlah Penjualan',
                data: [<?php echo $data_chart; ?>],
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: "#f3f3f3" } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>