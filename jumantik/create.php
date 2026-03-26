<?php
header("Content-Type: application/json");
require_once '../config/database.php';

// --- TAMBAHKAN KODE INI (PENERJEMAH JSON) ---
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Kalau Flutter ngirim JSON, kita pindahin isinya ke $_POST
if ($data) {
    $_POST = $data;
}

// LOGGING UNTUK DEBUG
file_put_contents(__DIR__ . "/debug_log.txt", "RAW JSON:\n" . $json . "\n\nPOST:\n" . print_r($_POST, true) . "\n\n", FILE_APPEND);
// --------------------------------------------

$id_keluarga   = $_POST['id_keluarga'] ?? null;
$status_jentik = $_POST['status_jentik'] ?? null;
$tanggal       = $_POST['tanggal'] ?? null;
$petugas       = $_POST['petugas'] ?? null;
$wadah         = $_POST['sumber_air'] ?? '';
$catatan       = $_POST['catatan'] ?? '';

// Proses Foto Base64 jika ada
$foto_path = '';
if (!empty($_POST['foto_base64'])) {
    $base64_string = $_POST['foto_base64'];
    if (strpos($base64_string, ',') !== false) {
        $base64_string = explode(',', $base64_string)[1];
    }
    
    $image_data = base64_decode($base64_string);
    $filename = "jumantik_" . time() . "_" . rand(1000, 9999) . ".jpg";
    $upload_dir = __DIR__ . "/../uploads/";
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $filepath = $upload_dir . $filename;
    
    if (file_put_contents($filepath, $image_data)) {
        $foto_path = "uploads/" . $filename;
    }
}

if (!$id_keluarga || !$status_jentik || !$tanggal || !$petugas) {
    echo json_encode([
        "status" => false,
        "message" => "Data wajib tidak lengkap!"
    ]);
    exit;
}

$sql = "INSERT INTO jumantik (id_keluarga, status_jentik, wadah, catatan, foto, tanggal, petugas) 
        VALUES ('$id_keluarga', '$status_jentik', '$wadah', '$catatan', '$foto_path', '$tanggal', '$petugas')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => true, "message" => "Laporan Berhasil Disimpan"]);
} else {
    echo json_encode(["status" => false, "message" => "Database Error: " . mysqli_error($conn)]);
}
?>