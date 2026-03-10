<?php
header("Content-Type: application/json");
require_once '../config/database.php';

// Ambil ID Keluarga dan Nama Kepala Keluarga (JOIN ke tabel warga)
// Liat: k.id_kepala_keluarga dikawinin sama w.id_warga
$query = "SELECT 
            k.id_keluarga, 
            w.nama as nama_warga, 
            k.no_kk 
          FROM keluarga k
          JOIN warga w ON k.id_kepala_keluarga = w.id_warga";

$result = mysqli_query($conn, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode([
        "status" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => false, 
        "message" => "Gagal ambil data: " . mysqli_error($conn)
    ]);
}
?>