<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

try {
    include "../config/database.php";

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (isset($data['judul']) && isset($data['isi'])) {
        $id       = isset($data['id_pengumuman']) ? mysqli_real_escape_string($conn, (string)$data['id_pengumuman']) : '';
        $id_alt   = isset($data['id']) ? mysqli_real_escape_string($conn, (string)$data['id']) : '';
        if ($id == '' && $id_alt != '') $id = $id_alt;
        
        $judul    = mysqli_real_escape_string($conn, (string)$data['judul']);
        $isi      = mysqli_real_escape_string($conn, (string)$data['isi']);
        
        $tanggal  = isset($data['tanggal']) ? mysqli_real_escape_string($conn, (string)$data['tanggal']) : date('Y-m-d');
        $waktu    = isset($data['waktu']) ? mysqli_real_escape_string($conn, (string)$data['waktu']) : '';
        $kategori = isset($data['kategori']) ? mysqli_real_escape_string($conn, (string)$data['kategori']) : 'INFO';
        $lokasi   = isset($data['lokasi']) ? mysqli_real_escape_string($conn, (string)$data['lokasi']) : 'Balai Warga';

        if ($id != '') {
            $sql = "UPDATE pengumuman SET judul='$judul', isi='$isi', tanggal='$tanggal', waktu='$waktu', kategori='$kategori', lokasi='$lokasi' WHERE id_pengumuman='$id'";
        } else {
            // Fallback for extreme cases
            $sql = "UPDATE pengumuman SET isi='$isi', waktu='$waktu', kategori='$kategori', lokasi='$lokasi' WHERE judul='$judul' AND tanggal='$tanggal'";
        }
                
        file_put_contents('debug.txt', $sql);
        file_put_contents('debug_data.txt', print_r($data, true));
        
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $affected = mysqli_affected_rows($conn);
            if ($affected > 0) {
               echo json_encode(["status" => true, "message" => "Pengumuman berhasil diupdate"]);
            } else {
               // Force it to be true to avoid breaking UI, but at least we know it affected 0 rows
               echo json_encode(["status" => true, "message" => "Opsi diupdate, tapi tidak ada baris yang berubah (affected=0)"]);
            }
        } else {
            echo json_encode(["status" => false, "message" => "Gagal update database: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => false, "message" => "Parameter tidak lengkap"]);
    }
} catch (Throwable $t) {
    http_response_code(200); 
    echo json_encode(["status" => false, "message" => "SERVER FATAL ERROR: " . $t->getMessage()]);
}
?>
