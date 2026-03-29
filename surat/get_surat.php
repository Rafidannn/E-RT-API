<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$db_path = '../config/database.php';
if(file_exists($db_path)) include_once $db_path;   

try {
    if (!isset($conn)) throw new Exception("DB Connection not found");
    
    $nik = $_GET['nik'] ?? '';

    if (!empty($nik)) {
        // Dipanggil User
        $stmt = $conn->prepare("SELECT *, id_surat AS id FROM surat_pengantar WHERE nik = ? ORDER BY id_surat DESC");
        $stmt->bind_param("s", $nik);
    } else {
        // Dipanggil Admin
        $stmt = $conn->prepare("
            SELECT p.*, p.id_surat AS id, 
                   w.nama AS nama_lengkap, 
                   'Kepala Keluarga' AS status_keluarga, 
                   k.alamat_lengkap AS alamat, 
                   SUBSTRING_INDEX(k.rt_rw, '/', 1) AS rt, 
                   SUBSTRING_INDEX(k.rt_rw, '/', -1) AS rw, 
                   '-' AS blok 
            FROM surat_pengantar p
            LEFT JOIN warga w ON p.nik = w.nik
            LEFT JOIN keluarga k ON w.id_keluarga = k.id_keluarga
            ORDER BY p.id_surat DESC
        ");
    }

    if (!$stmt) {
        throw new Exception("Query error: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $data]);

} catch(\Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
