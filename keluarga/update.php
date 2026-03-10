<?php
header("Content-Type: application/json");
require_once '../config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $id = $data['id_keluarga'];
    $no_kk = $data['no_kk'];
    $alamat = $data['alamat_lengkap'];
    $ekonomi = $data['status_ekonomi'];
    $air = $data['sumber_air'];
    $sampah = $data['pengelolaan_sampah'];
    $jamban = $data['memiliki_jamban'];

    $sql = "UPDATE keluarga SET 
            no_kk = '$no_kk', 
            alamat_lengkap = '$alamat', 
            status_ekonomi = '$ekonomi', 
            sumber_air = '$air', 
            pengelolaan_sampah = '$sampah', 
            memiliki_jamban = '$jamban' 
            WHERE id_keluarga = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => true, "message" => "Update Berhasil"]);
    } else {
        echo json_encode(["status" => false, "message" => mysqli_error($conn)]);
    }
}
?>