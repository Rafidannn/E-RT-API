<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

include '../config/database.php';

$id_keluarga = $_POST['id_keluarga'] ?? null;
$id_user = $_POST['id_user'] ?? 1; 
$jenis = $_POST['jenis_iuran'] ?? '';
$nominal = str_replace('.', '', $_POST['nominal'] ?? '0');
$bulan = $_POST['bulan'] ?? '';
$tahun = $_POST['tahun'] ?? date('Y');
$metode = $_POST['metode_pembayaran'] ?? 'Tunai';
$catatan = $_POST['catatan'] ?? '';
$tgl = date('Y-m-d');
$transaction_id = '#TRX-' . date('YmdHis') . rand(100, 999);
$bukti_transfer = null;

if(isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == UPLOAD_ERR_OK) {
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    $tmp_name = $_FILES['bukti_transfer']['tmp_name'];
    $filename = time() . '_' . $_FILES['bukti_transfer']['name'];
    $destination = 'uploads/' . $filename;
    if(move_uploaded_file($tmp_name, $destination)) {
        $bukti_transfer = $destination;
    }
}

if($id_keluarga) {
    $sql = "INSERT INTO iuran (id_keluarga, id_user, jenis_iuran, bulan, tahun, nominal, status, metode_pembayaran, catatan, tanggal_bayar, bukti_transfer, transaction_id) 
            VALUES ('$id_keluarga', '$id_user', '$jenis', '$bulan', '$tahun', '$nominal', 'pending', '$metode', '$catatan', '$tgl', '$bukti_transfer', '$transaction_id')";

    if($conn->query($sql)) {
        echo json_encode(["status" => "success", "transaction_id" => $transaction_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    $raw = file_get_contents('php://input');
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap. POST=" . json_encode($_POST) . " RAW=" . substr($raw, 0, 100)]);
}
exit();
?>