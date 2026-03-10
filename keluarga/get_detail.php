<?php
header("Content-Type: application/json");
require_once '../config/database.php';

$id_keluarga = $_GET['id_keluarga'] ?? null;

if (!$id_keluarga) {
    echo json_encode(["status" => false, "message" => "ID Keluarga tidak ditemukan"]);
    exit;
}

// 1. Ambil Detail Rumah (Data Ekonomi, Alamat, dll)
$q_rumah = "SELECT k.*, w.nama as nama_kepala 
            FROM keluarga k 
            LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
            WHERE k.id_keluarga = '$id_keluarga'";
$res_rumah = mysqli_query($conn, $q_rumah);
$data_rumah = mysqli_fetch_assoc($res_rumah);

// 2. Ambil Semua Anggota Keluarga yang tinggal di situ
$q_anggota = "SELECT * FROM warga WHERE id_keluarga = '$id_keluarga' ORDER BY id_warga ASC";
$res_anggota = mysqli_query($conn, $q_anggota);
$anggota = [];
while ($row = mysqli_fetch_assoc($res_anggota)) {
    $anggota[] = $row;
}

if ($data_rumah) {
    echo json_encode([
        "status" => true,
        "data" => [
            "info" => $data_rumah,
            "anggota" => $anggota
        ]
    ]);
} else {
    echo json_encode(["status" => false, "message" => "Data tidak ditemukan"]);
}
?>