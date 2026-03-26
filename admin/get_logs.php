<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include '../config/database.php';

$logs = [];

// Fetch from warga
$res_warga = mysqli_query($conn, "SELECT nama FROM warga ORDER BY id_warga DESC LIMIT 3");
if ($res_warga) {
    while($row = mysqli_fetch_assoc($res_warga)) {
        $logs[] = [
            "icon" => "person_add",
            "message" => "Data warga baru ditambahkan: " . $row['nama'],
            "time" => "Baru saja",
            "color" => "blue"
        ];
    }
}

// Fetch from iuran
$res_iuran = mysqli_query($conn, "SELECT nominal, status, tanggal_bayar FROM iuran ORDER BY id_iuran DESC LIMIT 3");
if ($res_iuran) {
    while($row = mysqli_fetch_assoc($res_iuran)) {
        $logs[] = [
            "icon" => "wallet",
            "message" => "Iuran senilai " . $row['nominal'] . " status: " . $row['status'],
            "time" => $row['tanggal_bayar'] ?? "Hari ini",
            "color" => "orange"
        ];
    }
}

// Fetch from pengumuman
$res_pengumuman = mysqli_query($conn, "SELECT judul, tanggal FROM pengumuman ORDER BY id_pengumuman DESC LIMIT 3");
if ($res_pengumuman) {
    while($row = mysqli_fetch_assoc($res_pengumuman)) {
        $logs[] = [
            "icon" => "campaign",
            "message" => "Pengumuman: " . $row['judul'],
            "time" => $row['tanggal'] ?? "Baru saja",
            "color" => "green"
        ];
    }
}

// Randomize lightly as combined latest updates
shuffle($logs);

echo json_encode(["status" => true, "data" => $logs]);
?>
