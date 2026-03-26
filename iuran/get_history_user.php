<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

// Terima dari JSON body, POST, atau GET
$id_keluarga = isset($data['id_keluarga']) ? $data['id_keluarga'] : (isset($_POST['id_keluarga']) ? $_POST['id_keluarga'] : (isset($_GET['id_keluarga']) ? $_GET['id_keluarga'] : ''));
$nik = isset($data['nik']) ? $data['nik'] : (isset($_POST['nik']) ? $_POST['nik'] : (isset($_GET['nik']) ? $_GET['nik'] : ''));

if (empty($id_keluarga) && empty($nik)) {
    echo json_encode(["status" => "error", "message" => "ERROR: NIK atau ID Keluarga wajib diisi."]);
    exit;
}

// Jika NIK dikirim, cari id_keluarga-nya dari tabel warga
if (!empty($nik) && empty($id_keluarga)) {
    $sql_warga = "SELECT id_keluarga FROM warga WHERE nik = '$nik' LIMIT 1";
    $res_warga = $conn->query($sql_warga);
    if ($res_warga && $res_warga->num_rows > 0) {
        $row_warga = $res_warga->fetch_assoc();
        $id_keluarga = $row_warga['id_keluarga'];
    } else {
        echo json_encode(["status" => "error", "message" => "Data warga tidak ditemukan untuk NIK: $nik"]);
        exit;
    }
}

$base_sql = "SELECT i.*, COALESCE(w.nama, u.nama, 'Warga') as nama_kepala, 
               COALESCE(k.no_kk, 'Belum diset') as no_kk 
        FROM iuran i 
        LEFT JOIN keluarga k ON i.id_keluarga = k.id_keluarga 
        LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
        LEFT JOIN users u ON i.id_user = u.id_user ";

if ($id_keluarga === 'all') {
    $sql = $base_sql . "ORDER BY i.id_iuran DESC";
} elseif (!empty($id_keluarga)) {
    $sql = $base_sql . "WHERE i.id_keluarga = '$id_keluarga' ORDER BY i.id_iuran DESC"; 
} elseif (!empty($nik)) {
    $sql = $base_sql . "WHERE u.nik = '$nik' OR i.id_keluarga IN (SELECT id_keluarga FROM warga WHERE nik = '$nik') ORDER BY i.id_iuran DESC";
}

$result = $conn->query($sql);

$riwayat = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $riwayat
]);
?>