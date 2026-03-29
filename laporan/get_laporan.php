<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

try {
    $nik = $_GET['nik'] ?? '';

    if (!empty($nik)) {
        // User fetch
        $sql = "SELECT id_laporan, subjek, kategori, status, 
                COALESCE(tanggal, tanggal_laporan) AS tanggal_laporan 
                FROM laporan WHERE nik=? ORDER BY id_laporan DESC";
                
        // Fallback if the column names mismatch
        $sql = "SELECT * FROM laporan WHERE nik=? ORDER BY id DESC"; 
        
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            $sql = "SELECT * FROM laporan WHERE nik=? ORDER BY id DESC";
            $stmt = mysqli_prepare($conn, $sql);
        }
        if (!$stmt) throw new Exception("Gagal prepare statement: " . mysqli_error($conn));

        mysqli_stmt_bind_param($stmt, "s", $nik);
    } else {
        // Admin fetch ALL
        // Include Pelapor name by joining or just select *
        $sql = "SELECT l.*, w.nama_lengkap as nama FROM laporan l LEFT JOIN warga w ON l.nik = w.nik ORDER BY l.id DESC";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) throw new Exception("Gagal prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);
    
    $res = mysqli_stmt_get_result($stmt);
    $data = [];
    
    while($r = mysqli_fetch_assoc($res)){
        // Ensure frontend gets 'tanggal_laporan' as it expects
        if(!isset($r['tanggal_laporan']) && isset($r['tanggal'])) {
            $r['tanggal_laporan'] = $r['tanggal'];
        }
        $data[] = $r;
    }
    
    echo json_encode(["status" => "success", "data" => $data]);
    
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>