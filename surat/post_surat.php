<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");
try {
    include '../config/database.php';

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

    $nik = $_POST['nik'] ?? '';
    $jenis_surat = $_POST['jenis_surat'] ?? '';
    $keperluan = $_POST['keperluan'] ?? '';
    $metode = $_POST['metode_pengambilan'] ?? 'Fisik';
    
    if(!$nik || !$jenis_surat || !$keperluan) {
        throw new Exception("Data form tidak lengkap");
    }

    $bukti = null;
    if(isset($_FILES['file_lampiran']) && $_FILES['file_lampiran']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if(!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = 'surat_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['file_lampiran']['name']);
        $dest = $uploadDir . $filename;
        if(move_uploaded_file($_FILES['file_lampiran']['tmp_name'], $dest)) {
            $bukti = $filename; // Simpan hanya nama file, bukan path
        }
    }

    $stmt = $conn->prepare("INSERT INTO surat_pengantar (nik, jenis_surat, keperluan, file_lampiran, metode_pengambilan, status) VALUES (?, ?, ?, ?, ?, 'MENUNGGU')");
    $stmt->bind_param("sssss", $nik, $jenis_surat, $keperluan, $bukti, $metode);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else throw new Exception($stmt->error);

} catch (\Throwable $e) {
    echo json_encode(["status"=>"error", "message"=>$e->getMessage()]);
}
?>
