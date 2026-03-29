<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include_once '../config/database.php';

$nik = $_GET['nik'] ?? '';

if (empty($nik)) {
    echo json_encode(["status" => "error", "message" => "NIK tidak ditemukan."]);
    exit();
}

$query = "SELECT w.*, k.no_kk, wk.nama as nama_kepala 
          FROM warga w 
          LEFT JOIN keluarga k ON w.id_keluarga = k.id_keluarga 
          LEFT JOIN warga wk ON k.id_kepala_keluarga = wk.id_warga 
          WHERE w.nik = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $nik);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(["status" => "success", "data" => $row]);
} else {
<<<<<<< HEAD
    // Cek juga di tabel users jika tidak ada di warga (untuk akun admin/petugas)
=======
    // Fallback ke tabel users jika tidak ada di warga
>>>>>>> cbd9d5592b2b33e1c59a2e36f895562bc04957b3
    $query_user = "SELECT * FROM users WHERE nik = ?";
    $stmt_user = mysqli_prepare($conn, $query_user);
    mysqli_stmt_bind_param($stmt_user, "s", $nik);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);
    
    if ($row_user = mysqli_fetch_assoc($result_user)) {
        echo json_encode(["status" => "success", "data" => $row_user]);
    } else {
        echo json_encode(["status" => "error", "message" => "NIK tidak terdaftar dalam sistem."]);
    }
}
?>
