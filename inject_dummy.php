<?php
include 'config/database.php';

$conn->query("CREATE TABLE IF NOT EXISTS pengumuman (id_pengumuman INT AUTO_INCREMENT PRIMARY KEY, judul VARCHAR(255), isi TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
$conn->query("INSERT INTO pengumuman (judul, isi) VALUES ('Sistem Terhubung!', 'API Notifikasi telah berhasil dihubungkan ke database. (Pesan otomatis)')");

echo "Dummy data injected.";
?>
