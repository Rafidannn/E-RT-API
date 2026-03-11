<?php
header("Content-Type: application/json");
include '../config/database.php';

// Bersihkan output buffer buat jaga-jaga ada spasi nyelip
ob_clean(); 

$sql = "SELECT id_keluarga, no_kk FROM keluarga ORDER BY no_kk ASC";
$result = $conn->query($sql);

$data = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $data[] = [
            "id_keluarga" => (string)$row['id_keluarga'],
            "no_kk" => $row['no_kk']
        ];
    }
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
exit(); // Tambahin ini biar gak ada output lain
?>