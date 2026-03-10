<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_keluarga'])) {
    $id_keluarga = $data['id_keluarga'];
    $jenis = $data['jenis_iuran'];
    $nominal = $data['nominal'];
    $bulan = $data['bulan'];
    $tahun = $data['tahun'];
    $tgl = date('Y-m-d');

    $sql = "INSERT INTO iuran (id_keluarga, jenis_iuran, nominal, bulan, tahun, status, tanggal_bayar) 
            VALUES ('$id_keluarga', '$jenis', '$nominal', '$bulan', '$tahun', 'lunas', '$tgl')";

    if($conn->query($sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}
?>