<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");

try {
    include '../config/database.php';

    $id_keluarga = $_POST['id_keluarga'] ?? null;
    $id_user = $_POST['id_user'] ?? 1; 
    $jenis = $_POST['jenis_iuran'] ?? '';
    $nominal = str_replace('.', '', $_POST['nominal'] ?? '0');
    $bulan = $_POST['bulan'] ?? '';
    $tahun = $_POST['tahun'] ?? date('Y');
    $metode = $_POST['metode_pembayaran'] ?? 'Tunai';
    $catatan = $_POST['catatan'] ?? '';
    $tgl = date('Y-m-d');
    $transaction_id = '#TRX-' . date('YmdHis') . rand(100, 999);
    $bukti_transfer = null;

    if(isset($_FILES['bukti_transfer'])) {
        if($_FILES['bukti_transfer']['error'] == UPLOAD_ERR_INI_SIZE || $_FILES['bukti_transfer']['error'] == UPLOAD_ERR_FORM_SIZE) {
            echo json_encode(["status" => "error", "message" => "Foto terlalu besar! Setting maksimal XAMPP (upload_max_filesize) tertembus!"]);
            exit;
        } elseif ($_FILES['bukti_transfer']['error'] != UPLOAD_ERR_OK && $_FILES['bukti_transfer']['error'] != UPLOAD_ERR_NO_FILE) {
            echo json_encode(["status" => "error", "message" => "Gagal upload foto. Kode Sistem: " . $_FILES['bukti_transfer']['error']]);
            exit;
        }

        if ($_FILES['bukti_transfer']['error'] == UPLOAD_ERR_OK) {
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }
            $tmp_name = $_FILES['bukti_transfer']['tmp_name'];
            $filename = time() . '_' . $_FILES['bukti_transfer']['name'];
            $destination = 'uploads/' . $filename;
            if(move_uploaded_file($tmp_name, $destination)) {
                $bukti_transfer = $destination;
            } else {
                echo json_encode(["status" => "error", "message" => "Gagal mindahin file di partisi XAMPP! Cek Folder Permissions!"]);
                exit;
            }
        }
    }

    if($id_keluarga) {
        // Prepare to prevent SQL injection and exceptions
        $sql = "INSERT INTO iuran (id_keluarga, id_user, jenis_iuran, bulan, tahun, nominal, status, metode_pembayaran, catatan, tanggal_bayar, bukti_transfer, transaction_id) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("sssssssssss", $id_keluarga, $id_user, $jenis, $bulan, $tahun, $nominal, $metode, $catatan, $tgl, $bukti_transfer, $transaction_id);
        
        if($stmt->execute()) {
            echo json_encode(["status" => "success", "transaction_id" => $transaction_id]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
        $stmt->close();
    } else {
        $raw = file_get_contents('php://input');
        echo json_encode(["status" => "error", "message" => "Data tidak lengkap. POST=" . json_encode($_POST)]);
    }

} catch (\Throwable $e) {
    // Catch ANY fatal error or exception and output as JSON safely
    echo json_encode([
        "status" => "error",
        "message" => "Fatal PHP Error: " . $e->getMessage()
    ]);
}
exit();
?>