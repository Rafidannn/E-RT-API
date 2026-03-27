<?php
header("Content-Type: application/json");
try {
    include '../config/database.php';
    $nik = $_GET['nik'] ?? '';
    if(!$nik) throw new Exception("NIK is required");
    
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

    $sql = "SELECT id_laporan, subjek, kategori, status, tanggal_laporan FROM laporan WHERE nik=? ORDER BY id_laporan DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $res = $stmt->get_result();
    
    $data = [];
    while($r = $res->fetch_assoc()){
        $data[] = $r;
    }
    echo json_encode(["status" => "success", "data" => $laporan]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal mengambil data laporan: " . mysqli_error($conn)]);
}
?>
