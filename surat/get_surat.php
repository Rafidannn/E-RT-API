<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");
try {
    include '../config/database.php';
    $nik = $_GET['nik'] ?? '';
    if(!$nik) throw new Exception("NIK is required");
    
    $create_sql = "CREATE TABLE IF NOT EXISTS surat_pengantar (
        id_surat INT AUTO_INCREMENT PRIMARY KEY,
        nik VARCHAR(50) NOT NULL,
        jenis_surat VARCHAR(100),
        keperluan TEXT,
        file_lampiran VARCHAR(255) DEFAULT NULL,
        metode_pengambilan ENUM('Fisik', 'Digital') DEFAULT 'Fisik',
        status ENUM('MENUNGGU', 'DISETUJUI', 'DITOLAK') DEFAULT 'MENUNGGU',
        catatan_admin TEXT DEFAULT NULL,
        tanggal_pengajuan DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $conn->query($create_sql);

    $sql = "SELECT * FROM surat_pengantar WHERE nik=? ORDER BY id_surat DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $res = $stmt->get_result();
    
    $data = [];
    while($r = $res->fetch_assoc()){
        $data[] = $r;
    }
    echo json_encode(["status"=>"success", "data"=>$data]);
} catch (\Throwable $e) {
    echo json_encode(["status"=>"error", "message"=>$e->getMessage()]);
}
?>
