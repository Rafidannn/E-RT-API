<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include_once '../config/database.php';

$nik = $_GET['nik'] ?? '';

if (!empty($nik)) {
    $query = "SELECT * FROM laporan WHERE nik = ? ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $query = "SELECT * FROM laporan ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
}

$laporan = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $laporan[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $laporan]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal mengambil data laporan: " . mysqli_error($conn)]);
}
?>
