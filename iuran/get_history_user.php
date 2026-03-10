<?php
header("Content-Type: application/json");
include '../config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Pastikan mengambil id_keluarga dari Flutter
$id_keluarga = isset($data['id_keluarga']) ? mysqli_real_escape_string($conn, $data['id_keluarga']) : '';

if ($id_keluarga == "") {
    echo json_encode(["status" => "error", "message" => "ID Keluarga tidak dikirim"]);
    exit;
}

// Ambil data iuran berdasarkan ID Keluarga
$sql = "SELECT * FROM iuran WHERE id_keluarga = '$id_keluarga' ORDER BY id_iuran DESC";
$result = $conn->query($sql);

$riwayat = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $riwayat
]);
?>