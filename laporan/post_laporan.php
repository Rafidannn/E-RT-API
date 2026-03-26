<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");
try {
    include '../config/database.php';

    $create_sql = "CREATE TABLE IF NOT EXISTS laporan (
        id_laporan INT AUTO_INCREMENT PRIMARY KEY,
        nik VARCHAR(50) NOT NULL,
        subjek VARCHAR(150),
        kategori VARCHAR(50),
        detail TEXT,
        foto_bukti VARCHAR(255) DEFAULT NULL,
        lokasi VARCHAR(255) DEFAULT NULL,
        status ENUM('TERKIRIM', 'DIPROSES', 'SELESAI', 'DITOLAK') DEFAULT 'TERKIRIM',
        tanggal_laporan DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $conn->query($create_sql);

    $nik = $_POST['nik'] ?? '';
    $subjek = $_POST['subjek'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $detail = $_POST['detail'] ?? '';
    $lokasi = $_POST['lokasi'] ?? '';
    
    if(!$nik || !$subjek) {
        throw new Exception("Data form tidak lengkap");
    }

    $bukti = null;
    if(isset($_FILES['foto_bukti']) && $_FILES['foto_bukti']['error'] == UPLOAD_ERR_OK) {
        if(!file_exists('uploads')) mkdir('uploads', 0777, true);
        $dest = 'uploads/' . time() . '_' . str_replace(" ", "_", $_FILES['foto_bukti']['name']);
        if(move_uploaded_file($_FILES['foto_bukti']['tmp_name'], $dest)) {
            $bukti = $dest;
        }
    }

    $stmt = $conn->prepare("INSERT INTO laporan (nik, subjek, kategori, detail, foto_bukti, lokasi, status) VALUES (?, ?, ?, ?, ?, ?, 'TERKIRIM')");
    if(!$stmt) throw new Exception("DB PREPARE ERROR");
    $stmt->bind_param("ssssss", $nik, $subjek, $kategori, $detail, $bukti, $lokasi);
    if($stmt->execute()) echo json_encode(["status"=>"success"]);
    else throw new Exception($stmt->error);

} catch (\Throwable $e) {
    echo json_encode(["status"=>"error", "message"=>$e->getMessage()]);
}
?>
