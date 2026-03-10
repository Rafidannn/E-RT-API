<?php
include '../config/database.php';
include '../response.php';

header('Content-Type: application/json');

// Query untuk mengambil riwayat posyandu beserta nama warganya
$sql = "SELECT p.*, w.nama as nama_warga 
        FROM posyandu p 
        JOIN warga w ON p.id_warga = w.id_warga 
        ORDER BY p.tanggal DESC, p.id_posyandu DESC";

$result = mysqli_query($conn, $sql);

if ($result) {
    $list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
    response(true, "Berhasil mengambil riwayat posyandu", $list);
} else {
    response(false, "Gagal mengambil data: " . mysqli_error($conn));
}
?>