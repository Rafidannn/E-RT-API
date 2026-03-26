<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$id_keluarga = isset($data['id_keluarga']) ? $data['id_keluarga'] : (isset($_POST['id_keluarga']) ? $_POST['id_keluarga'] : (isset($_GET['id_keluarga']) ? $_GET['id_keluarga'] : ''));
$nik = isset($data['nik']) ? $data['nik'] : (isset($_POST['nik']) ? $_POST['nik'] : (isset($_GET['nik']) ? $_GET['nik'] : ''));

if (empty($id_keluarga) && empty($nik)) {
    echo json_encode(["status" => "error", "message" => "ERROR DARI PHP: NIK tidak diterima backend. Pastikan sudah relogin agar memory tersimpan dengan benar! NIK yang masuk: '$nik'"]);
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
        echo json_encode(["status" => "error", "message" => "Data warga tidak ditemukan"]);
        exit;
    }
}

// Ambil data iuran berdasarkan ID Keluarga (atau semua jika id = all), plus join nama kepala keluarga
if ($id_keluarga === 'all') {
    $sql = "SELECT i.*, COALESCE(w.nama, u.nama, 'Warga') as nama_kepala, 
                   COALESCE(k.no_kk, kk.no_kk, kk_nik.no_kk, 'Belum diset') as no_kk 
            FROM iuran i 
            LEFT JOIN keluarga k ON i.id_keluarga = k.id_keluarga 
            LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
            LEFT JOIN users u ON i.id_user = u.id_user
            LEFT JOIN warga w2 ON i.id_user = w2.id_warga
            LEFT JOIN keluarga kk ON w2.id_keluarga = kk.id_keluarga
            LEFT JOIN warga w_nik ON i.id_keluarga = w_nik.nik 
            LEFT JOIN keluarga kk_nik ON w_nik.id_keluarga = kk_nik.id_keluarga 
            ORDER BY i.id_iuran DESC";
} else {
    $sql = "SELECT i.*, COALESCE(w.nama, u.nama, 'Warga') as nama_kepala, 
                   COALESCE(k.no_kk, kk.no_kk, kk_nik.no_kk, 'Belum diset') as no_kk 
            FROM iuran i 
            LEFT JOIN keluarga k ON i.id_keluarga = k.id_keluarga 
            LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
            LEFT JOIN users u ON i.id_user = u.id_user
            LEFT JOIN warga w2 ON i.id_user = w2.id_warga
            LEFT JOIN keluarga kk ON w2.id_keluarga = kk.id_keluarga
            LEFT JOIN warga w_nik ON i.id_keluarga = w_nik.nik 
            LEFT JOIN keluarga kk_nik ON w_nik.id_keluarga = kk_nik.id_keluarga 
            WHERE i.id_keluarga = '$id_keluarga' 
            ORDER BY i.id_iuran DESC";
}
$result = $conn->query($sql);

$riwayat = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $riwayat[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $riwayat
]);
?>