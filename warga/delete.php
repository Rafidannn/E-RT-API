<?php
header("Content-Type: application/json");
include '../config/database.php';

// Ambil data JSON dari Flutter
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan id_warga ada di dalam request
if (!empty($data['id_warga'])) {
    $id_warga = $data['id_warga'];

    // Query hapus berdasarkan id_warga
    $query = "DELETE FROM warga WHERE id_warga = '$id_warga'";
    
    if (mysqli_query($conn, $query)) {
        // Cek apakah ada baris yang terhapus (mastiin ID-nya emang ada di db)
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode([
                "status" => "success", 
                "message" => "Data warga berhasil dihapus"
            ]);
        } else {
            echo json_encode([
                "status" => "error", 
                "message" => "Data tidak ditemukan, gagal menghapus"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Gagal menghapus: " . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "ID Warga tidak disertakan"
    ]);
}
?>