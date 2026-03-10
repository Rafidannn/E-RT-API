<?php
header("Content-Type: application/json");
include '../config/database.php'; // Pastiin file ini ada di folder config

// Pake $conn karena di file sebelumnya lu pake $conn
$query = "SELECT COUNT(*) as total FROM warga";
$result = mysqli_query($conn, $query); 

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        "status" => true,
        "total_warga" => (int)$row['total'] // Paksa jadi angka
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => mysqli_error($conn)
    ]);
}
?>