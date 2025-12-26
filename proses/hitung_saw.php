<?php
include '../config/koneksi.php';

// Ambil bobot dan tipe
$kriteria = mysqli_query($conn, "SELECT * FROM kriteria");

// Ambil semua data nilai
$nilai = mysqli_query($conn, "SELECT * FROM nilai");

// Normalisasi
$normalisasi = [];
foreach ($kriteria as $k) {
    $idk = $k['id_kriteria'];
    $tipe = $k['tipe'];
    $max = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(nilai) FROM nilai WHERE id_kriteria='$idk'"))[0];
    $min = mysqli_fetch_array(mysqli_query($conn, "SELECT MIN(nilai) FROM nilai WHERE id_kriteria='$idk'"))[0];

    $queryNilai = mysqli_query($conn, "SELECT * FROM nilai WHERE id_kriteria='$idk'");
    while ($n = mysqli_fetch_array($queryNilai)) {
        $r = ($tipe == 'benefit') ? $n['nilai'] / $max : $min / $n['nilai'];
        $normalisasi[$n['id_buku']][$idk] = $r;
    }
}

// Hitung nilai preferensi
$hasil = [];
foreach ($normalisasi as $id_buku => $krs) {
    $vi = 0;
    foreach ($kriteria as $k) {
        $idk = $k['id_kriteria'];
        $vi += $k['bobot'] * $krs[$idk];
    }
    $hasil[$id_buku] = $vi;
}

// Urutkan
arsort($hasil);

// Tampilkan hasil
foreach ($hasil as $id_buku => $nilai) {
    $buku = mysqli_fetch_array(mysqli_query($conn, "SELECT judul_buku FROM buku WHERE id_buku='$id_buku'"));
    echo $buku['judul_buku']." : ".round($nilai,4)."<br>";
}
?>
