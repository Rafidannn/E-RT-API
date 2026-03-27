<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$id_keluarga = isset($data['id_keluarga']) ? $data['id_keluarga'] : '';
$nik = isset($data['nik']) ? $data['nik'] : '';

if (empty($id_keluarga) && empty($nik)) {
    echo json_encode(["status" => "error", "message" => "Error: Exception: ID Keluarga mana cuk?"]);
    exit;
}

$base_sql = "SELECT i.*, COALESCE(w.nama, u.nama, 'Warga') as nama_kepala, 
               COALESCE(k.no_kk, kk.no_kk, kk_nik.no_kk, 'Belum diset') as no_kk 
        FROM iuran i 
        LEFT JOIN keluarga k ON i.id_keluarga = k.id_keluarga 
        LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
        LEFT JOIN users u ON i.id_user = u.id_user
        LEFT JOIN warga w2 ON i.id_user = w2.id_warga
        LEFT JOIN keluarga kk ON w2.id_keluarga = kk.id_keluarga
        LEFT JOIN warga w_nik ON i.id_keluarga = w_nik.nik 
        LEFT JOIN keluarga kk_nik ON w_nik.id_keluarga = kk_nik.id_keluarga ";

// Ambil data iuran berdasarkan ID Keluarga atau NIK
if ($id_keluarga === 'all') {
    $sql = $base_sql . "ORDER BY i.id_iuran DESC";
} elseif (!empty($id_keluarga)) {
    $sql = $base_sql . "WHERE i.id_keluarga = '$id_keluarga' ORDER BY i.id_iuran DESC"; 
} elseif (!empty($nik)) {
    $sql = $base_sql . "WHERE u.nik = '$nik' OR i.id_user IN (SELECT id_user FROM users WHERE nik = '$nik') OR i.id_keluarga IN (SELECT id_keluarga FROM warga WHERE nik = '$nik') ORDER BY i.id_iuran DESC";
}

$result = $conn->query($sql);

$riwayat = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $riwayat
]);
?>