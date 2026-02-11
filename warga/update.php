<?php
header("Content-Type: application/json");
include '../config/database.php';

// Ambil data JSON dari Flutter
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan id_warga ada untuk menentukan data mana yang diupdate
if (!empty($data['id_warga'])) {
    $id_warga = $data['id_warga'];
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
    $bpjs_aktif = $data['bpjs_aktif']; // Nilai 1 atau 0

    // Query Update
    $query = "UPDATE warga SET 
                id_keluarga = '$id_keluarga', 
                nama = '$nama', 
                nik = '$nik', 
                tempat_lahir = '$tempat_lahir', 
                tanggal_lahir = '$tanggal_lahir', 
                jenis_kelamin = '$jenis_kelamin', 
                pendidikan = '$pendidikan', 
                pekerjaan = '$pekerjaan', 
                status_perkawinan = '$status_perkawinan', 
                status_kesehatan_khusus = '$status_kesehatan_khusus', 
                bpjs_aktif = '$bpjs_aktif' 
              WHERE id_warga = '$id_warga'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => "success", 
            "message" => "Data warga berhasil diperbarui"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Gagal update: " . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "ID Warga tidak ditemukan"
    ]);
}
?>