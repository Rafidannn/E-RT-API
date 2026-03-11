<?php
// Buat nangkis error HTML biar gak bocor ke Flutter dan bikin FormatException
ob_start(); 
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once '../config/database.php';

// Fungsi helper buat kirim respon JSON murni
function kirimRespon($status, $message) {
    ob_clean(); // Hapus output sampah sebelum kirim JSON
    echo json_encode([
        "status" => $status ? "success" : "error", 
        "message" => $message
    ]);
    exit;
}

// Ambil input JSON dari Flutter
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['nama']) && !empty($data['nik'])) {
    
    // Ambil data dan kasih default value kalo kosong
    // id_keluarga bisa NULL kalo emang dia mau dijadiin kepala keluarga baru nanti
    $id_keluarga    = !empty($data['id_keluarga']) ? $data['id_keluarga'] : null;
    $nama           = $data['nama'];
    $nik            = $data['nik'];
    $tempat_lahir   = $data['tempat_lahir'] ?? '';
    $tanggal_lahir  = $data['tanggal_lahir'] ?? '';
    $jenis_kelamin  = $data['jenis_kelamin'] ?? 'L';
    $pendidikan     = $data['pendidikan'] ?? '';
    $pekerjaan      = $data['pekerjaan'] ?? '';
    $status_kawin   = $data['status_perkawinan'] ?? 'belum_kawin';
    $status_sehat   = $data['status_kesehatan_khusus'] ?? 'umum';
    $bpjs_aktif     = isset($data['bpjs_aktif']) ? (int)$data['bpjs_aktif'] : 1;

    // --- PAKE PREPARED STATEMENTS BIAR AMAN COK ---
    $query = "INSERT INTO warga (
                id_keluarga, nama, nik, tempat_lahir, tanggal_lahir, 
                jenis_kelamin, pendidikan, pekerjaan, status_perkawinan, 
                status_kesehatan_khusus, bpjs_aktif
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Pastiin variabel koneksi lu $conn (sesuai database.php tadi)
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        kirimRespon(false, "Gagal prepare query: " . $conn->error);
    }

    // Bind parameter (i = integer, s = string)
    $stmt->bind_param("isssssssssi", 
        $id_keluarga, 
        $nama, 
        $nik, 
        $tempat_lahir, 
        $tanggal_lahir, 
        $jenis_kelamin, 
        $pendidikan, 
        $pekerjaan, 
        $status_kawin, 
        $status_sehat, 
        $bpjs_aktif
    );

    if ($stmt->execute()) {
        kirimRespon(true, "Warga $nama berhasil didata!");
    } else {
        // Kalo gagal (misal NIK Duplikat)
        kirimRespon(false, "Gagal simpan: " . $stmt->error);
    }

    $stmt->close();
} else {
    kirimRespon(false, "Nama dan NIK wajib diisi!");
}
?>