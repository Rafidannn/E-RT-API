<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include '../config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$nik = $data['nik'] ?? null;
$nama = $data['nama'] ?? null;

if (empty($nik) || empty($nama)) {
    echo json_encode(["status" => false, "message" => "NIK dan Nama tidak boleh kosong"]);
    exit;
}

$nik_safe = mysqli_real_escape_string($conn, $nik);
$nama_safe = mysqli_real_escape_string($conn, $nama);

$sql = "UPDATE users SET nama = '$nama_safe' WHERE nik = '$nik_safe'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => true, "message" => "Profil berhasil diperbarui"]);
} else {
    echo json_encode(["status" => false, "message" => "Gagal menyimpan database: " . mysqli_error($conn)]);
}
?>
