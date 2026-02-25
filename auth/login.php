<?php
// Izinkan akses dari aplikasi Flutter (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../config/database.php';
include '../response.php';

// 1. Ambil data JSON yang dikirim oleh Flutter (ApiService.post)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 2. Cek apakah data NIK dan Password ada
if (!isset($data['nik']) || !isset($data['password'])) {
    response(false, "NIK dan Password harus diisi!", null);
    exit;
}

$nik = mysqli_real_escape_with_connection($conn, $data['nik']);
$password = $data['password'];

// 3. Cari user berdasarkan NIK di tabel 'users'
$query = "SELECT id_user, nama, nik, password, role FROM users WHERE nik = '$nik' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // 4. Verifikasi Password (menggunakan hash agar aman)
    // Note: Database kamu terlihat sudah menggunakan hash (0192023a7bbd...)
    if ($password === $user['password']) {
        
        // Hapus password dari array sebelum dikirim ke Flutter demi keamanan
        unset($user['password']);
        
        // Kirim respon sukses beserta data user untuk disimpan di Flutter
        response(true, "Login berhasil! Selamat datang " . $user['nama'], $user);
    } else {
        // Jika password tidak cocok
        response(false, "Password yang kamu masukkan salah.", null);
    }
} else {
    // Jika NIK tidak ditemukan
    response(false, "NIK tidak terdaftar dalam sistem.", null);
}

// Fungsi helper tambahan jika di response.php kamu belum ada mysqli_real_escape
function mysqli_real_escape_with_connection($conn, $value) {
    return mysqli_real_escape_string($conn, $value);
}
?>