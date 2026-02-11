<?php
include '../config/database.php';
include '../response.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id_keluarga  = $data['id_keluarga'];
$status_jentik = $data['status_jentik']; // 'ada' atau 'tidak'
$petugas      = $data['petugas']; // id_user dari Flutter
$tanggal      = date('Y-m-d');

$sql = "INSERT INTO jumantik (id_keluarga, status_jentik, tanggal, petugas) 
        VALUES ('$id_keluarga', '$status_jentik', '$tanggal', '$petugas')";

if ($conn->query($sql)) {
    sendResponse("success", "Data jumantik berhasil disimpan");
} else {
    sendResponse("error", "Gagal menyimpan data: " . $conn->error);
}
?>