<?php
header("Content-Type: application/json");
include '../config/database.php';

// AUTO MIGRATION: Jika kolom 'is_verified' belum ada, tambahkan ke tabel users
$res = $conn->query("SHOW COLUMNS FROM `users` LIKE 'is_verified'");
if ($res && $res->num_rows == 0) {
    $conn->query("ALTER TABLE `users` ADD COLUMN `is_verified` TINYINT(1) DEFAULT 0");
    // Asumsikan admin atau role selain pending lgsg aktif duluan dari data lama
    $conn->query("UPDATE `users` SET is_verified = 1");
}

// AMBIL LIST USER (belum terverifikasi)
// Join ke warga pake NIK, kalo ketemu artinya Terdaftar, klo kaga ya T. Terdaftar
$sql = "SELECT u.id_user, u.nama as nama_lengkap, u.nik, u.role, u.created_at, w.id_warga 
        FROM users u 
        LEFT JOIN warga w ON u.nik = w.nik 
        WHERE u.is_verified = 0 
        ORDER BY u.created_at DESC";

$result = $conn->query($sql);
$data = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $waktu = date('H.i', strtotime($row['created_at'])); 
        $tanggal = date('d-m-Y', strtotime($row['created_at']));
        
        $data[] = [
            "id_user" => $row['id_user'],
            "nama_lengkap" => $row['nama_lengkap'],
            "nik" => $row['nik'],
            "waktu_daftar" => "$waktu ($tanggal)",
            "status_daftar" => ($row['id_warga']) ? "Terdaftar" : "T. Terdaftar",
            "role_saat_ini" => $row['role']
        ];
    }
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
?>
