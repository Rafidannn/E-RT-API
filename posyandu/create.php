<?php
include '../config/database.php';
include '../response.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id_warga    = $data['id_warga'];
$kategori    = $data['kategori']; // 'balita' atau 'lansia'
$berat_badan = $data['berat_badan'];
$tinggi_badan = $data['tinggi_badan'];
$hasil       = $data['hasil'];
$petugas     = $data['petugas'];
$tanggal     = date('Y-m-d');

$sql = "INSERT INTO posyandu (id_warga, kategori, berat_badan, tinggi_badan, hasil, tanggal, petugas) 
        VALUES ('$id_warga', '$kategori', '$berat_badan', '$tinggi_badan', '$hasil', '$tanggal', '$petugas')";

if ($conn->query($sql)) {
    sendResponse("success", "Data posyandu berhasil dicatat");
} else {
    sendResponse("error", "Gagal mencatat data");
}
?>