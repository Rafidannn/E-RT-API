<?php
header('Content-Type: application/json');
require '../config/database.php';

$nik = $_POST['nik'] ?? '';
$jenis_surat = $_POST['jenis_surat'] ?? '';
$keperluan = $_POST['keperluan'] ?? '';
$metode_pengambilan = $_POST['metode_pengambilan'] ?? '';

if(empty($nik) || empty($jenis_surat) || empty($keperluan) || empty($metode_pengambilan)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua kolom wajib diisi']);
    exit;
}

$file_lampiran = null;
if(isset($_FILES['file_lampiran']) && $_FILES['file_lampiran']['error'] == 0) {
    $upload_dir = '../uploads/';
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_name = time() . '_' . basename($_FILES['file_lampiran']['name']);
    $target_file = $upload_dir . $file_name;
    
    if(move_uploaded_file($_FILES['file_lampiran']['tmp_name'], $target_file)) {
        $file_lampiran = 'uploads/' . $file_name;
    }
}

$stmt = $conn->prepare("INSERT INTO pengajuan_surat (nik, jenis_surat, keperluan, metode_pengambilan, file_lampiran) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nik, $jenis_surat, $keperluan, $metode_pengambilan, $file_lampiran);

if($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Surat berhasil diajukan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal DB: ' . $stmt->error]);
}
$stmt->close();
$conn->close();
?>
