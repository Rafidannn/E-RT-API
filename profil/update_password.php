<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include '../config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$nik = $data['nik'] ?? '';
$old_password = $data['old_password'] ?? '';
$new_password = $data['new_password'] ?? '';

if (empty($nik) || empty($old_password) || empty($new_password)) {
    echo json_encode(["status" => false, "message" => "Lengkapi semua data sandi"]);
    exit;
}

$nik_safe = mysqli_real_escape_string($conn, $nik);
$sql = "SELECT password FROM users WHERE nik = '$nik_safe'";
$res = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($res)) {
    if ($row['password'] == $old_password) {
        $new_safe = mysqli_real_escape_string($conn, $new_password);
        $update = "UPDATE users SET password = '$new_safe' WHERE nik = '$nik_safe'";
        if (mysqli_query($conn, $update)) {
            echo json_encode(["status" => true, "message" => "Kata sandi berhasil diganti!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Error update password server"]);
        }
    } else {
        echo json_encode(["status" => false, "message" => "Kata sandi lama salah!"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Akun User tidak ditemukan"]);
}
?>
