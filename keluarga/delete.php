<?php
header("Content-Type: application/json");
require_once '../config/database.php';

// Ambil input JSON dari Flutter
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id_keluarga = $data['id_keluarga'] ?? null;

if (!$id_keluarga) {
    echo json_encode([
        "status" => false, 
        "message" => "ID Keluarga tidak ditemukan cok!"
    ]);
    exit;
}

// Proses Hapus
$sql = "DELETE FROM keluarga WHERE id_keluarga = '$id_keluarga'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => true,
        "message" => "Data keluarga berhasil dihapus"
    ]);
} else {
    // Kalau gagal (biasanya karena masih ada data warga di dalamnya)
    echo json_encode([
        "status" => false, 
        "message" => "Gagal hapus: " . mysqli_error($conn)
    ]);
}
?>