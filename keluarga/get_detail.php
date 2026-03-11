<?php
header("Content-Type: application/json");
require_once '../config/database.php';

$id_keluarga = $_GET['id_keluarga'];

if (!empty($id_keluarga)) {
    // 1. Ambil Info Keluarga & Nama Kepala
    $sql_info = "SELECT k.*, w.nama as nama_kepala 
                 FROM keluarga k 
                 LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
                 WHERE k.id_keluarga = '$id_keluarga'";
    
    $res_info = mysqli_query($conn, $sql_info);
    $info = mysqli_fetch_assoc($res_info);

    // 2. Ambil Daftar Anggota Keluarga
    $sql_anggota = "SELECT * FROM warga WHERE id_keluarga = '$id_keluarga'";
    $res_anggota = mysqli_query($conn, $sql_anggota);
    
    $anggota = [];
    while ($row = mysqli_fetch_assoc($res_anggota)) {
        $anggota[] = $row;
    }

    if ($info) {
        echo json_encode([
            "status" => true,
            "data" => [
                "info" => $info,
                "anggota" => $anggota
            ]
        ]);
    } else {
        echo json_encode(["status" => false, "message" => "Data tidak ditemukan"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "ID tidak ada"]);
}