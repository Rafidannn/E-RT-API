<?php
header("Content-Type: application/json");
include '../config/database.php'; // Pastiin path-nya bener ke file database.php lu

// Ambil warga yang id_keluarga-nya masih 0 atau NULL (Warga yang belum masuk KK manapun)
$query = "SELECT id_warga, nama, nik FROM warga WHERE id_keluarga IS NULL OR id_keluarga = 0";
$result = mysqli_query($conn, $query);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode(["status" => true, "data" => $data]);
} else {
    echo json_encode(["status" => false, "message" => mysqli_error($conn)]);
}
?>