<?php
header("Content-Type: application/json");
include '../config/database.php'; 

// Itung selisih tahun sekarang dengan tanggal_lahir atau dari status_kesehatan_khusus
$query = "SELECT COUNT(*) as total FROM warga WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60 OR LOWER(status_kesehatan_khusus) = 'lansia'";
$result = mysqli_query($conn, $query); 

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        "status" => true,
        "total_lansia" => (int)$row['total']
    ]);
} else {
    echo json_encode(["status" => false, "message" => mysqli_error($conn)]);
}
?>