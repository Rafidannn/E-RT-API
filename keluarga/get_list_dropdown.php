<?php
// PAKSA ERROR KELUAR SEMUA
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// INPUT MANUAL KONEKSI BIAR PASTI JALAN
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ert"; // <--- PASTIIN NAMA DATABASE LU 'ert'

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die(json_encode(["status" => false, "message" => "Koneksi Gagal: " . mysqli_connect_error()]));
}

// QUERY JOIN (Gue samain ama screenshot tabel warga lu tadi)
// k.id_kepala_keluarga harus nyambung ke w.id_warga
// Ganti w.nama_warga jadi w.nama (atau cek di phpMyAdmin lu kolomnya apa)
$sql = "SELECT k.id_keluarga, w.nama as nama_warga, k.no_kk 
        FROM keluarga k 
        JOIN warga w ON k.id_kepala_keluarga = w.id_warga";

$result = mysqli_query($conn, $sql);

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
    // KALO QUERY SALAH, DIA BAKAL TERIAK DI SINI
    echo json_encode([
        "status" => false, 
        "message" => "Query Error: " . mysqli_error($conn)
    ]);
}
?>