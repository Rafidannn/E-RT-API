<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true) ?: $_POST;

$id = $data['id'] ?? '';
$action = $data['action'] ?? ''; // 'terima' or 'tolak'

if (empty($id) || empty($action)) {
    echo json_encode(["status" => "error", "message" => "ID dan Action dibutuhkan."]);
    exit();
}

$status = ($action === 'terima') ? 'lunas' : 'ditolak';

$query = "UPDATE iuran SET status = ? WHERE id_iuran = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "si", $status, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status" => "success", "message" => "Status berhasil diupdate menjadi $status"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal merubah status: " . mysqli_error($conn)]);
}
?>
