<?php
include '../config/database.php';
include '../response.php';

// Cek apakah methodnya POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Pastikan data tidak kosong
    if (isset($data['id_warga']) && isset($data['kategori'])) {
        
        // Escape string untuk keamanan
        $id_warga     = mysqli_real_escape_string($conn, $data['id_warga']);
        $kategori     = mysqli_real_escape_string($conn, $data['kategori']); 
        $berat_badan  = mysqli_real_escape_string($conn, $data['berat_badan']);
        $tinggi_badan = mysqli_real_escape_string($conn, $data['tinggi_badan']);
        $hasil        = mysqli_real_escape_string($conn, $data['hasil']);
        $petugas      = mysqli_real_escape_string($conn, $data['petugas']);
        $tanggal      = date('Y-m-d');

        $sql = "INSERT INTO posyandu (id_warga, kategori, berat_badan, tinggi_badan, hasil, tanggal, petugas) 
                VALUES ('$id_warga', '$kategori', '$berat_badan', '$tinggi_badan', '$hasil', '$tanggal', '$petugas')";

        if (mysqli_query($conn, $sql)) {
            // Gunakan fungsi response yang sesuai dengan file response.php kamu
            response(true, "Data posyandu berhasil dicatat");
        } else {
            response(false, "Gagal mencatat data: " . mysqli_error($conn));
        }
    } else {
        response(false, "Data tidak lengkap");
    }
} else {
    response(false, "Method tidak diizinkan");
}
?>