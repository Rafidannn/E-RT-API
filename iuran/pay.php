<?php
// Matikan semua error reporting agar tidak merusak JSON
error_reporting(0); 
header("Content-Type: application/json");

include '../config/database.php';

// Buang semua output yang mungkin nempel (seperti spasi/enter)
ob_clean();

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['id_keluarga'])) {
    $id_keluarga = $data['id_keluarga'];
    $id_user = $data['id_user'] ?? 1; 
    $jenis = $data['jenis_iuran'];
    $nominal = str_replace('.', '', $data['nominal']); // Hapus titik kalau ada (misal 10.000 jadi 10000)
    $bulan = $data['bulan'];
    $tahun = $data['tahun'];
    $metode = $data['metode_pembayaran'];
    $catatan = $data['catatan'] ?? '';
    $tgl = date('Y-m-d');

    // Baris 24 di pay.php lu ubah jadi gini:
$sql = "INSERT INTO iuran (id_keluarga, id_user, jenis_iuran, bulan, tahun, nominal, status, metode_pembayaran, catatan, tanggal_bayar) 
        VALUES ('$id_keluarga', '$id_user', '$jenis', '$bulan', '$tahun', '$nominal', 'lunas', '$metode', '$catatan', '$tgl')";

    if($conn->query($sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
}
exit(); // Pastikan berhenti di sini
?>