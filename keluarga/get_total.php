<?php
header("Content-Type: application/json");
include '../config/database.php'; 

// Query buat ngitung total keluarga
$query = "SELECT COUNT(*) as total FROM keluarga";
$result = mysqli_query($conn, $query); 

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        "status" => true,
        "total_keluarga" => (int)$row['total']
    ]);
} else {
    echo json_encode([
        "status" => false, 
        "message" => "Gagal query database"
    ]);
}
?>