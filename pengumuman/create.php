<?php
// TAMPILKAN ERROR ASLI BIAR KETAHUAN PENYAKITNYA
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

try {
    include "../config/database.php";
    include "../response.php";

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (isset($data['judul']) && isset($data['isi'])) {
        $judul    = mysqli_real_escape_string($conn, $data['judul']);
        $isi      = mysqli_real_escape_string($conn, $data['isi']);
        $user_id  = mysqli_real_escape_string($conn, $data['user_id']);
        
        $tanggal  = isset($data['tanggal']) ? mysqli_real_escape_string($conn, $data['tanggal']) : date('Y-m-d');
        $waktu    = isset($data['waktu']) ? mysqli_real_escape_string($conn, $data['waktu']) : '';
        $kategori = isset($data['kategori']) ? mysqli_real_escape_string($conn, $data['kategori']) : 'INFO';
        $lokasi   = isset($data['lokasi']) ? mysqli_real_escape_string($conn, $data['lokasi']) : 'Balai Warga';

        // Proses foto
        $foto_filename = NULL;
        if (isset($data['foto_base64']) && !empty($data['foto_base64'])) {
            $foto_data = base64_decode($data['foto_base64']);
            $foto_filename = 'pengumuman_' . time() . '.jpg';
            if(!is_dir("../uploads")) {
                mkdir("../uploads", 0777, true);
            }
            file_put_contents("../uploads/" . $foto_filename, $foto_data);
        }
        
        $sql = "INSERT INTO pengumuman (judul, isi, tanggal, waktu, kategori, lokasi, foto, dibuat_oleh) 
                VALUES ('$judul', '$isi', '$tanggal', '$waktu', '$kategori', '$lokasi', " . 
                ($foto_filename ? "'$foto_filename'" : "NULL") . ", '$user_id')";
        
        try {
            $query = mysqli_query($conn, $sql);
        } catch (Exception $e) {
            $query = false;
            $errMsg = $e->getMessage();
            if (strpos($errMsg, "Unknown column") !== false) {
                 mysqli_query($conn, "ALTER TABLE pengumuman ADD COLUMN foto VARCHAR(255) NULL, ADD COLUMN waktu VARCHAR(50) NULL, ADD COLUMN kategori VARCHAR(50) NULL, ADD COLUMN lokasi VARCHAR(100) NULL");
                 $query = mysqli_query($conn, $sql);
            } else {
                 throw $e;
            }
        }

        if ($query) {
            echo json_encode(["status" => true, "message" => "Pengumuman berhasil ditambahkan"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal simpan ke database: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => false, "message" => "Data tidak lengkap atau format salah"]);
    }
} catch (Throwable $t) {
    http_response_code(200); // Paksa return HTTP 200 agar terbaca sebagai JSON oleh Flutter
    echo json_encode([
        "status" => false, 
        "message" => "SERVER FATAL ERROR: " . $t->getMessage() . " di " . $t->getFile() . " baris " . $t->getLine()
    ]);
}
?>