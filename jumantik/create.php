<?php
header("Content-Type: application/json");
require_once '../config/database.php';

// --- TAMBAHKAN KODE INI (PENERJEMAH JSON) ---
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Kalau Flutter ngirim JSON, kita pindahin isinya ke $_POST
if ($data) {
    $_POST = $data;
}
// --------------------------------------------

$id_keluarga   = $_POST['id_keluarga'] ?? null;
$status_jentik = $_POST['status_jentik'] ?? null;
$tanggal       = $_POST['tanggal'] ?? null;
$petugas       = $_POST['petugas'] ?? null;

if (!$id_keluarga || !$status_jentik || !$tanggal || !$petugas) {
    echo json_encode([
        "status" => false,
        "message" => "Data tidak lengkap! ID Keluarga: $id_keluarga, Status: $status_jentik, Tgl: $tanggal, Petugas: $petugas"
    ]);
    exit;
}

$sql = "INSERT INTO jumantik (id_keluarga, status_jentik, tanggal, petugas) 
        VALUES ('$id_keluarga', '$status_jentik', '$tanggal', '$petugas')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => true, "message" => "Laporan Berhasil Disimpan"]);
} else {
    echo json_encode(["status" => false, "message" => "Database Error: " . mysqli_error($conn)]);
}
?>