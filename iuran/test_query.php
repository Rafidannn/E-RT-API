<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';

$sql = "SELECT i.id_iuran, i.id_keluarga, i.id_user, w.nama as nama_kepala, k.no_kk 
        FROM iuran i 
        LEFT JOIN keluarga k ON i.id_keluarga = k.id_keluarga 
        LEFT JOIN warga w ON k.id_kepala_keluarga = w.id_warga 
        ORDER BY i.id_iuran DESC LIMIT 5";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
