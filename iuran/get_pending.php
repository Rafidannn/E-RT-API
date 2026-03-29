<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable raw text errors to avoid breaking JSON

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include_once '../config/database.php';

try {
    $sql_join = "SELECT i.*, COALESCE(w.nama, u.nama, 'Warga') as nama, 
                       COALESCE(k.no_kk, kk.no_kk, kk_nik.no_kk, '-') as kk 
                FROM iuran i 
                LEFT JOIN keluarga k ON i.id_keluarga = k.id_keluarga 
                LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
                LEFT JOIN users u ON i.id_user = u.id_user
                LEFT JOIN warga w2 ON i.id_user = w2.id_warga
                LEFT JOIN keluarga kk ON w2.id_keluarga = kk.id_keluarga
                LEFT JOIN warga w_nik ON i.id_keluarga = w_nik.nik 
                LEFT JOIN keluarga kk_nik ON w_nik.id_keluarga = kk_nik.id_keluarga";

    // Pending
    $query = "$sql_join WHERE i.status = 'Menunggu' OR LOWER(i.status) = 'pending' ORDER BY i.tanggal_bayar DESC";
    $res_pending = $conn->query($query);
    $pending_data = [];
    if ($res_pending && $res_pending->num_rows > 0) {
        while($row = $res_pending->fetch_assoc()) {
            $pending_data[] = $row;
        }
    }

    // Selesai
    $query_selesai = "$sql_join WHERE LOWER(i.status) = 'lunas' OR LOWER(i.status) = 'ditolak' ORDER BY i.tanggal_bayar DESC LIMIT 50";
    $res_selesai = $conn->query($query_selesai);
    $selesai_data = [];
    if ($res_selesai && $res_selesai->num_rows > 0) {
        while($row = $res_selesai->fetch_assoc()) {
            $selesai_data[] = $row;
        }
    }

    echo json_encode([
        "status" => "success",
        "menunggu" => $pending_data,
        "selesai" => $selesai_data
    ]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
