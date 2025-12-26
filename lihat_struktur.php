<?php
/**
 * Script sederhana untuk menampilkan struktur folder & file proyek PHP.
 * Jalankan: php lihat_struktur.php
 */

$root = __DIR__; // direktori tempat file ini berada

function tampilkanStruktur($dir, $indent = 0) {
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $file;
        $spasi = str_repeat("│   ", $indent);

        if (is_dir($path)) {
            echo "{$spasi}📁 {$file}\n";
            tampilkanStruktur($path, $indent + 1);
        } else {
            echo "{$spasi}📄 {$file}\n";
        }
    }
}

echo "📂 Struktur Folder: " . basename($root) . "\n";
echo str_repeat("=", 50) . "\n";
tampilkanStruktur($root);
echo str_repeat("=", 50) . "\n";
echo "✅ Total selesai ditampilkan.\n";
?>
