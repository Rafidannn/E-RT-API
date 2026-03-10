<?php
header("Content-Type: application/json");
include '../config/database.php'; 

// Itung selisih tahun sekarang dengan tanggal_lahir di tabel lu
$query = "SELECT COUNT(*) as total FROM warga WHERE TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60";
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