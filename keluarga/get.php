<?php
header("Content-Type: application/json");
require_once '../config/database.php';

// Pake LEFT JOIN dan ambil semua kolom keluarga (k.*)
// Tambahin IFNULL biar kalo gak ada kepalanya, muncul tulisan "Belum Set"
$query = "SELECT 
            k.*, 
            IFNULL(w.nama, 'Belum Set') as nama_warga 
          FROM keluarga k
          LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga
          ORDER BY k.id_keluarga DESC";

$result = mysqli_query($conn, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Pastiin tipe datanya bener buat Flutter
        $row['id_keluarga'] = (int)$row['id_keluarga'];
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