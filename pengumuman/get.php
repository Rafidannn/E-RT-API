<?php
include '../config/database.php';
include '../response.php';

// Menambahkan header JSON agar Flutter mendeteksi format dengan benar
header('Content-Type: application/json');

$query = "
SELECT p.id_pengumuman, p.judul, p.isi, p.tanggal, p.waktu, p.kategori, p.lokasi, p.foto,
        u.nama AS pembuat
FROM pengumuman p
LEFT JOIN users u ON p.dibuat_oleh = u.id_user
ORDER BY p.tanggal DESC, p.id_pengumuman DESC
";

$result = mysqli_query($conn, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    // Menggunakan fungsi response sesuai kode kamu
    response(true, "Data pengumuman berhasil diambil", $data);
} else {
    // Jika query gagal
    response(false, "Gagal mengambil data: " . mysqli_error($conn), []);
}
?>