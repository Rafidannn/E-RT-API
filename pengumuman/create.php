<?php
include "../config/database.php";
include "../response.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['judul']) && isset($data['isi'])) {
    $judul    = mysqli_real_escape_string($conn, $data['judul']);
    $isi      = mysqli_real_escape_string($conn, $data['isi']);
    $user_id  = mysqli_real_escape_string($conn, $data['user_id']);
    
    $tanggal  = isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d');

    $sql = "INSERT INTO pengumuman (judul, isi, tanggal, dibuat_oleh) 
            VALUES ('$judul', '$isi', '$tanggal', '$user_id')";
    
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Berhasil beneran
        response(true, "Pengumuman berhasil ditambahkan");
    } else {
        // Gagal di database
        response(false, "Gagal simpan ke database: " . mysqli_error($conn));
    }
} else {
    // Data yang dikirim Flutter tidak lengkap
    response(false, "Data tidak lengkap atau format salah");
}
?>