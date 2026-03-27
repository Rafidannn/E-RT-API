<?php
header("Content-Type: application/json");
require_once '../config/database.php';

// Query JOIN - Pastiin nama tabelnya 'users' bukan 'user'
$query = "SELECT 
            j.*, 
            k.no_kk,
            k.alamat_lengkap,
            w.nama as nama_kepala_keluarga,
            u.nama as nama_petugas
          FROM jumantik j
          JOIN keluarga k ON j.id_keluarga = k.id_keluarga
          JOIN warga w ON k.id_kepala_keluarga = w.id_warga
          JOIN users u ON j.petugas = u.id_user 
          ORDER BY j.tanggal DESC, j.id_jumantik DESC";

$result = mysqli_query($conn, $query);

if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode([
        "status" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => false, 
        "message" => "Database Error: " . mysqli_error($conn)
    ]);
}
?>