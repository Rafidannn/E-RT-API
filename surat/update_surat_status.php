<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

$db_path = '../config/database.php';
if(file_exists($db_path)) include_once $db_path;   

try {
    if (!isset($conn)) throw new Exception("DB Connection not found");

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data)) {
        $data = $_POST;
    }

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;
    $catatan = $data['catatan_admin'] ?? '';

    if(empty($id) || empty($status)) {
        throw new Exception('ID Surat dan Status wajib diisi');
    }

    $stmt = $conn->prepare("UPDATE surat_pengantar SET status = ?, catatan_admin = ? WHERE id_surat = ?");
    $stmt->bind_param("ssi", $status, $catatan, $id);

    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Status surat berhasil diupdate']);
    } else {
        throw new Exception('Gagal mengubah status: ' . $stmt->error);
    }
} catch(\Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
