<?php
header("Content-Type: application/json");
include '../config/database.php';

// Bersihkan output buffer buat jaga-jaga ada spasi nyelip
ob_clean(); 

$sql = "SELECT k.id_keluarga, k.no_kk, w.nama as nama_kepala 
        FROM keluarga k 
        LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
        ORDER BY k.no_kk ASC";
$result = $conn->query($sql);

$data = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $data[] = [
            "id_keluarga" => (string)$row['id_keluarga'],
            "no_kk" => $row['no_kk'],
            "nama_kepala" => $row['nama_kepala']
        ];
    }
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
exit(); // Tambahin ini biar gak ada output lain
?>