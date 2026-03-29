<?php
header("Content-Type: application/json");
require_once 'config/database.php';

$warga = [];
$res1 = mysqli_query($conn, "SELECT id_warga, id_keluarga, nama, nik FROM warga");
while($r = mysqli_fetch_assoc($res1)) $warga[] = $r;

$keluarga = [];
$res2 = mysqli_query($conn, "SELECT id_keluarga, no_kk, id_kepala_keluarga FROM keluarga");
while($r = mysqli_fetch_assoc($res2)) $keluarga[] = $r;

$users = [];
$res3 = mysqli_query($conn, "SELECT id_user, nama, nik, role FROM users");
while($r = mysqli_fetch_assoc($res3)) $users[] = $r;

echo json_encode([
    'warga' => $warga,
    'keluarga' => $keluarga,
    'users' => $users
], JSON_PRETTY_PRINT);
?>
