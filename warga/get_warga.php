<?php
header("Content-Type: application/json");
include '../config/database.php';
include '../response.php'; // Pastikan file ini ada untuk fungsi response()

$id_warga = isset($_GET['id_warga']) ? mysqli_real_escape_string($conn, $_GET['id_warga']) : null;

if ($id_warga) {
    $query = "SELECT * FROM warga WHERE id_warga = '$id_warga'";
} else {
    $query = "SELECT * FROM warga ORDER BY nama ASC";
}

$result = mysqli_query($conn, $query);

if ($result) {
    $list_warga = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Casting ke tipe data yang benar
        $row['id_warga'] = (int)$row['id_warga'];
        $row['bpjs_aktif'] = (int)$row['bpjs_aktif'];
        $list_warga[] = $row;
    }

    if ($id_warga && empty($list_warga)) {
        response(false, "Warga tidak ditemukan");
    } else {
        $data = $id_warga ? $list_warga[0] : $list_warga;
        response(true, "Berhasil mengambil data warga", $data);
    }
} else {
    response(false, "Database error: " . mysqli_error($conn));
}
?>