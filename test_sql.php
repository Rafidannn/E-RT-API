<?php
require 'config/database.php';
$stmt = $conn->prepare("
        SELECT p.*, 
               w.nama AS nama_lengkap, 
               'Kepala Keluarga' AS status_keluarga, 
               k.alamat_lengkap AS alamat, 
               SUBSTRING_INDEX(k.rt_rw, '/', 1) AS rt, 
               SUBSTRING_INDEX(k.rt_rw, '/', -1) AS rw, 
               '-' AS blok 
        FROM pengajuan_surat p
        LEFT JOIN warga w ON p.nik = w.nik
        LEFT JOIN keluarga k ON w.id_keluarga = k.id_keluarga
        ORDER BY p.id DESC
");
if(!$stmt) {
    file_put_contents('test_log.txt', 'Error: ' . $conn->error);
} else {
    $stmt->execute();
    $res = $stmt->get_result();
    $data = [];
    while($row = $res->fetch_assoc()){
        $data[] = $row;
    }
    file_put_contents('test_log.txt', print_r($data, true));
}
?>
