<?php
header("Content-Type: application/json");
include '../config/database.php';

// Cek apakah ada parameter id_warga (buat ambil detail satu orang saja)
$id_warga = isset($_GET['id_warga']) ? $_GET['id_warga'] : null;

if ($id_warga) {
    // Ambil detail satu warga
    $query = "SELECT * FROM warga WHERE id_warga = '$id_warga'";
} else {
    // Ambil semua data warga
    $query = "SELECT * FROM warga ORDER BY id_warga DESC";
}

$result = mysqli_query($conn, $query);
$list_warga = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Pastikan format field sesuai dengan WargaModel lu
        $list_warga[] = [
            "id_warga" => $row['id_warga'],
            "id_keluarga" => $row['id_keluarga'],
            "nama" => $row['nama'],
            "nik" => $row['nik'],
            "tempat_lahir" => $row['tempat_lahir'],
            "tanggal_lahir" => $row['tanggal_lahir'],
            "jenis_kelamin" => $row['jenis_kelamin'],
            "pendidikan" => $row['pendidikan'],
            "pekerjaan" => $row['pekerjaan'],
            "status_perkawinan" => $row['status_perkawinan'],
            "status_kesehatan_khusus" => $row['status_kesehatan_khusus'],
            "bpjs_aktif" => $row['bpjs_aktif'] // Di DB 0/1, di Model jadi bool
        ];
    }

    if ($id_warga && empty($list_warga)) {
        echo json_encode(["status" => "error", "message" => "Warga tidak ditemukan"]);
    } else {
        echo json_encode([
            "status" => "success", 
            "data" => $id_warga ? $list_warga[0] : $list_warga
        ]);
    }
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}
?>