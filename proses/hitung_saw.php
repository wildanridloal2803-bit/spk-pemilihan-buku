<?php
include '../config/koneksi.php';

// 1. Bersihkan tabel hasil sebelum menghitung ulang (agar tidak duplikat)
mysqli_query($koneksi, "TRUNCATE TABLE hasil");

// 2. Ambil Data Kriteria dan Bobot
$kriteria_data = [];
$sql_kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria");
while($k = mysqli_fetch_assoc($sql_kriteria)){
    $kriteria_data[$k['id_kriteria']] = [
        'bobot' => $k['bobot'],
        'tipe'  => $k['tipe']
    ];
}

// 3. Cari Nilai Max/Min untuk Normalisasi
$min_max = [];
$sql_minmax = mysqli_query($koneksi, "SELECT id_kriteria, MAX(nilai) as max_v, MIN(nilai) as min_v FROM nilai GROUP BY id_kriteria");
while($mm = mysqli_fetch_assoc($sql_minmax)){
    $min_max[$mm['id_kriteria']] = [
        'max' => $mm['max_v'],
        'min' => $mm['min_v']
    ];
}

// 4. Ambil Buku dan Nilai-nilainya
$buku_data = [];
$sql_buku = mysqli_query($koneksi, "SELECT DISTINCT id_buku FROM nilai");
while($b = mysqli_fetch_assoc($sql_buku)){
    $id_buku = $b['id_buku'];
    $total_nilai = 0;

    // Ambil nilai mentah per buku
    $sql_nilai = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_buku='$id_buku'");
    while($n = mysqli_fetch_assoc($sql_nilai)){
        $id_k = $n['id_kriteria'];
        $val  = $n['nilai'];
        
        // --- LOGIKA NORMALISASI SAW ---
        $normalisasi = 0;
        $tipe = $kriteria_data[$id_k]['tipe'];
        
        if($tipe == 'benefit'){
            // Rumus Benefit: Nilai / Max
            $normalisasi = $val / $min_max[$id_k]['max'];
        } else {
            // Rumus Cost: Min / Nilai
            $normalisasi = $min_max[$id_k]['min'] / $val;
        }

        // --- PEMBOBOTAN ---
        $bobot = $kriteria_data[$id_k]['bobot'];
        $total_nilai += ($normalisasi * $bobot);
    }

    $buku_data[] = [
        'id_buku' => $id_buku,
        'final_score' => $total_nilai
    ];
}

// 5. Urutkan berdasarkan Nilai Tertinggi (Ranking)
usort($buku_data, function($a, $b) {
    return $b['final_score'] <=> $a['final_score'];
});

// 6. Simpan ke Database
$rank = 1;
foreach($buku_data as $res){
    $id = $res['id_buku'];
    $score = $res['final_score'];
    
    $insert = "INSERT INTO hasil (id_buku, nilai_preferensi, ranking) VALUES ('$id', '$score', '$rank')";
    mysqli_query($koneksi, $insert);
    $rank++;
}

// Redirect kembali ke halaman hasil
header("Location: ../index.php?page=hasil_saw");
?>