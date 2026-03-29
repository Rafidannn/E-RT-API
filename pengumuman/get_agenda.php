<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

try {
    include '../config/database.php';

    // Optional filter: ?tanggal=2026-03-29
    $tanggal = $_GET['tanggal'] ?? date('Y-m-d');

    $sql = "SELECT p.id_pengumuman, p.judul, p.isi, p.tanggal, p.waktu, p.kategori, p.lokasi, p.foto,
                   u.nama AS pembuat
            FROM pengumuman p
            LEFT JOIN users u ON p.dibuat_oleh = u.id_user
            WHERE p.tanggal = ?
            ORDER BY p.waktu ASC, p.created_at ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tanggal);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($r = $res->fetch_assoc()) {
        $data[] = $r;
    }

    // Cari event berikutnya (paling dekat setelah sekarang)
    $now = date('H:i:s');
    $nowDate = date('Y-m-d');
    $upcoming = null;

    // Cari upcoming di hari ini
    $sqlUp = "SELECT p.id_pengumuman, p.judul, p.isi, p.tanggal, p.waktu, p.kategori, p.lokasi, p.foto,
                     u.nama AS pembuat
              FROM pengumuman p
              LEFT JOIN users u ON p.dibuat_oleh = u.id_user
              WHERE p.tanggal >= ? AND p.waktu >= ?
              ORDER BY p.tanggal ASC, p.waktu ASC
              LIMIT 1";
    $stmtUp = $conn->prepare($sqlUp);
    $stmtUp->bind_param("ss", $nowDate, $now);
    $stmtUp->execute();
    $resUp = $stmtUp->get_result();
    if ($r = $resUp->fetch_assoc()) {
        $upcoming = $r;
    }

    echo json_encode([
        "status"   => "success",
        "tanggal"  => $tanggal,
        "upcoming" => $upcoming,
        "data"     => $data
    ]);
} catch (\Throwable $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
