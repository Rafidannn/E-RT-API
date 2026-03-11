<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$id_keluarga = isset($data['id_keluarga']) ? $data['id_keluarga'] : '';

if (empty($id_keluarga)) {
    echo json_encode(["status" => "error", "message" => "ID Keluarga mana cuk?"]);
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