<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Sesuaikan path ke database.php lu
include '../config/database.php'; 

// Ambil input JSON dari Flutter
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastiin key ini sama dengan yang dikirim di RegisterPage Flutter lu
    $nama     = $data['nama'] ?? '';
    $nik      = $data['nik'] ?? '';
    $password = $data['password'] ?? '';
    $role     = $data['role'] ?? '';

    // Validasi input kosong
    if (empty($nama) || empty($nik) || empty($password) || empty($role)) {
        echo json_encode([
            "status" => false,
            "message" => "Semua data harus diisi bos!"
        ]);
        exit;
    }

    // MODIFIKASI: Password langsung masuk tanpa di-hash (Plain Text)
    $final_password = $password;

    // Cek apakah NIK sudah dipakai
    $check_nik = mysqli_query($conn, "SELECT nik FROM users WHERE nik = '$nik'");
    
    if (mysqli_num_rows($check_nik) > 0) {
        echo json_encode([
            "status" => false,
            "message" => "NIK ini udah terdaftar, pake yang lain!"
        ]);
    } else {
        // Query Insert ke tabel users - Menggunakan $final_password yang bukan hash
        $sql = "INSERT INTO users (nama, nik, password, role) VALUES ('$nama', '$nik', '$final_password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode([
                "status" => true,
                "message" => "Registrasi Berhasil! Silakan Login."
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal simpan ke database: " . mysqli_error($conn)
            ]);
        }
    }
} else {
    echo json_encode([
        "status" => false,
        "message" => "Method harus POST"
    ]);
}
?>