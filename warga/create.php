<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['nama']) && !empty($data['nik'])) {
    $id_keluarga = mysqli_real_escape_string($conn, $data['id_keluarga']);
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $nik = mysqli_real_escape_string($conn, $data['nik']);
    $tempat_lahir = mysqli_real_escape_string($conn, $data['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $data['tanggal_lahir']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $data['jenis_kelamin']);
    $pendidikan = mysqli_real_escape_string($conn, $data['pendidikan']);
    $pekerjaan = mysqli_real_escape_string($conn, $data['pekerjaan']);
    $status_perkawinan = mysqli_real_escape_string($conn, $data['status_perkawinan']);
    $status_kesehatan_khusus = mysqli_real_escape_string($conn, $data['status_kesehatan_khusus']);
    $bpjs_aktif = mysqli_real_escape_string($conn, $data['bpjs_aktif']);

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