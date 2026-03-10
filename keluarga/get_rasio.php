<?php
header("Content-Type: application/json");
include '../config/database.php';

// Itung jumlah masing-masing kategori
$query = "SELECT 
            SUM(CASE WHEN status_ekonomi = 'mandiri' THEN 1 ELSE 0 END) as mandiri,
            SUM(CASE WHEN status_ekonomi = 'madya' THEN 1 ELSE 0 END) as madya,
            SUM(CASE WHEN status_ekonomi = 'prasejahtera' THEN 1 ELSE 0 END) as prasejahtera,
            COUNT(*) as total
          FROM keluarga";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

echo json_encode([
    "status" => true,
    "data" => [
        "mandiri" => (int)$row['mandiri'],
        "madya" => (int)$row['madya'],
        "prasejahtera" => (int)$row['prasejahtera'],
        "total" => (int)$row['total']
    ]
]);
?>