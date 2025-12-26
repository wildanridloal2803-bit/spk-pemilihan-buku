<?php
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Perhitungan SAW - SPK Buku Terlaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4 mb-5">
    <h3 class="fw-bold text-primary mb-3 text-center">📊 Hasil Perhitungan SAW</h3>

    <?php
    // 1️⃣ Ambil semua kriteria
    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
    $dataKriteria = [];
    while ($k = mysqli_fetch_assoc($kriteria)) {
        $dataKriteria[$k['id_kriteria']] = [
            'nama' => $k['nama_kriteria'],
            'bobot' => $k['bobot'],
            'tipe' => $k['tipe']
        ];
    }

    // 2️⃣ Ambil semua buku
    $buku = mysqli_query($conn, "SELECT * FROM buku");
    $dataBuku = [];
    while ($b = mysqli_fetch_assoc($buku)) {
        $dataBuku[$b['id_buku']] = $b['judul_buku'];
    }

    // 3️⃣ Ambil semua nilai
    $nilai = mysqli_query($conn, "SELECT * FROM nilai");
    $dataNilai = [];
    foreach ($nilai as $n) {
        $dataNilai[$n['id_buku']][$n['id_kriteria']] = $n['nilai'];
    }

    if (count($dataNilai) == 0) {
        echo "<div class='alert alert-warning'>Belum ada data nilai untuk dihitung.</div>";
        echo "<a href='../index.php' class='btn btn-secondary'>⬅ Kembali</a>";
        exit;
    }

    // 4️⃣ Normalisasi data
    $normalisasi = [];
    foreach ($dataKriteria as $id_k => $kr) {
        $kolomNilai = [];
        foreach ($dataNilai as $id_buku => $nilaiBuku) {
            $kolomNilai[] = $nilaiBuku[$id_k];
        }

        $max = max($kolomNilai);
        $min = min($kolomNilai);

        foreach ($dataNilai as $id_buku => $nilaiBuku) {
            $xij = $nilaiBuku[$id_k];
            if ($kr['tipe'] == 'benefit') {
                $r = $xij / $max;
            } else {
                $r = $min / $xij;
            }
            $normalisasi[$id_buku][$id_k] = $r;
        }
    }

    // 5️⃣ Hitung nilai preferensi (Vi)
    $hasil = [];
    foreach ($normalisasi as $id_buku => $nilaiBuku) {
        $vi = 0;
        foreach ($nilaiBuku as $id_k => $r) {
            $vi += $r * $dataKriteria[$id_k]['bobot'];
        }
        $hasil[$id_buku] = $vi;
    }

    // Urutkan hasil tertinggi → terendah
    arsort($hasil);
    ?>

    <!-- Tabel Matriks Keputusan -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white fw-bold">1️⃣ Matriks Keputusan (Nilai Asli)</div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Buku</th>
                        <?php foreach ($dataKriteria as $k): ?>
                            <th><?= $k['nama'] ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataNilai as $id_buku => $nilaiBuku): ?>
                        <tr>
                            <td class="text-start"><?= $dataBuku[$id_buku] ?></td>
                            <?php foreach ($dataKriteria as $id_k => $kr): ?>
                                <td><?= $nilaiBuku[$id_k] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Normalisasi -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white fw-bold">2️⃣ Hasil Normalisasi</div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Buku</th>
                        <?php foreach ($dataKriteria as $k): ?>
                            <th><?= $k['nama'] ?> (<?= ucfirst($k['tipe']) ?>)</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($normalisasi as $id_buku => $nilaiBuku): ?>
                        <tr>
                            <td class="text-start"><?= $dataBuku[$id_buku] ?></td>
                            <?php foreach ($nilaiBuku as $r): ?>
                                <td><?= round($r, 4) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Nilai Preferensi dan Ranking -->
    <div class="card mb-4">
        <div class="card-header bg-warning fw-bold">3️⃣ Nilai Preferensi (Vi) & Ranking Buku Terlaris</div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ranking</th>
                        <th>Buku</th>
                        <th>Nilai Akhir (Vi)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    foreach ($hasil as $id_buku => $vi):
                        // Simpan ke tabel hasil (opsional)
                        mysqli_query($conn, "
                            INSERT INTO hasil (id_buku, nilai_preferensi, ranking)
                            VALUES ('$id_buku', '$vi', '$rank')
                            ON DUPLICATE KEY UPDATE nilai_preferensi='$vi', ranking='$rank'
                        ");
                    ?>
                    <tr>
                        <td><?= $rank++ ?></td>
                        <td class="text-start"><?= $dataBuku[$id_buku] ?></td>
                        <td><?= round($vi, 4) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="../index.php" class="btn btn-secondary">⬅ Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
