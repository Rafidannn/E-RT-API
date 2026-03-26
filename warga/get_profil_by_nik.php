<?php
header("Content-Type: application/json");
include '../config/database.php';
$nik = $_GET['nik'] ?? '';

if(!$nik) { 
    echo json_encode(["status"=>"error", "message" => "NIK Required"]); 
    exit; 
}

$sql = "SELECT w.nama, k.no_kk, k.id_keluarga, 
               (SELECT nama FROM warga WHERE id_warga = k.id_kepala_keluarga) as nama_kepala,
               u.id_user
        FROM warga w 
        JOIN keluarga k ON w.id_keluarga = k.id_keluarga 
        LEFT JOIN users u ON w.nik = u.nik
        WHERE w.nik = '$nik'";
        
$res = $conn->query($sql);

if($res && $res->num_rows > 0) {
    echo json_encode(["status"=>"success", "data"=>$res->fetch_assoc()]);
} else {
    echo json_encode(["status"=>"error", "message" => "Not found"]);
}
?>
