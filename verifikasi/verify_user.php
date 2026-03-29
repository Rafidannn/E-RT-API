<?php
header("Content-Type: application/json");
include '../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$id_user = $data['id_user'] ?? '';
$action  = $data['action'] ?? '';  // "terima" atau "tolak"
$role    = $data['role'] ?? 'warga';

if (empty($id_user) || empty($action)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
    exit;
}

if ($action === 'terima') {
    $sql = "UPDATE `users` SET is_verified = 1, role = '$role' WHERE id_user = '$id_user'";
    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "User berhasil diverifikasi!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal update: " . $conn->error]);
    }
} else if ($action === 'tolak') {
    // Menghapus user sepenuhnya
    $sql = "DELETE FROM `users` WHERE id_user = '$id_user'";
    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Pendaftaran user ditolak & dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menghapus: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Aksi tidak dikenali"]);
}
?>
