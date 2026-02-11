<?php
header("Content-Type: application/json");
include '../config/database.php';

// Ambil data JSON dari Flutter
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['nama']) && !empty($data['nik'])) {
    $id_keluarga = $data['id_keluarga'];
    $nama = $data['nama'];
    $nik = $data['nik'];
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $pendidikan = $data['pendidikan'];
    $pekerjaan = $data['pekerjaan'];
    $status_perkawinan = $data['status_perkawinan'];
    $status_kesehatan_khusus = $data['status_kesehatan_khusus'];
    $bpjs_aktif = $data['bpjs_aktif']; // Nilainya 1 atau 0 dari toJson() lu

    $query = "INSERT INTO warga (
        id_keluarga, nama, nik, tempat_lahir, tanggal_lahir, 
        jenis_kelamin, pendidikan, pekerjaan, status_perkawinan, 
        status_kesehatan_khusus, bpjs_aktif
    ) VALUES (
        '$id_keluarga', '$nama', '$nik', '$tempat_lahir', '$tanggal_lahir', 
        '$jenis_kelamin', '$pendidikan', '$pekerjaan', '$status_perkawinan', 
        '$status_kesehatan_khusus', '$bpjs_aktif'
    )";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Warga berhasil didata"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Nama dan NIK wajib diisi"]);
}
?>