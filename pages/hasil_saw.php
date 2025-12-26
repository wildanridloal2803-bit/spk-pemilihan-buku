<h2>Hasil Perangkingan Buku Terlaris (Metode SAW)</h2>

<a href="proses/hitung_saw.php" class="btn-hitung" style="background:blue; color:white; padding:10px; text-decoration:none;">Hitung Ulang / Refresh Data</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Ranking</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Nilai Preferensi (V)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Join tabel hasil dengan tabel buku untuk mengambil nama buku
        $query = "SELECT h.*, b.judul_buku, b.penulis 
                  FROM hasil h 
                  JOIN buku b ON h.id_buku = b.id_buku 
                  ORDER BY h.ranking ASC";
        
        $result = mysqli_query($koneksi, $query);
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td align='center'>".$row['ranking']."</td>";
                echo "<td>".$row['judul_buku']."</td>";
                echo "<td>".$row['penulis']."</td>";
                echo "<td align='center'>".number_format($row['nilai_preferensi'], 4)."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' align='center'>Belum ada data hasil. Silakan klik tombol Hitung.</td></tr>";
        }
        ?>
    </tbody>
</table>