<?php
include '../config/database.php';
include '../response.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$id_keluarga = $data['id_keluarga'];

$sql = "SELECT * FROM iuran WHERE id_keluarga = '$id_keluarga' ORDER BY tahun DESC, bulan DESC";
$result = $conn->query($sql);

$iurans = [];
while($row = $result->fetch_assoc()) {
    $iurans[] = $row;
}

sendResponse("success", "Data iuran berhasil diambil", $iurans);
?>