ini post laporan
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

$nik = $_POST['nik'] ?? '';
$subjek = $_POST['subjek'] ?? '';
$kategori = $_POST['kategori'] ?? '';
$detail = $_POST['detail'] ?? '';
$lokasi = $_POST['lokasi'] ?? '';
$tanggal_laporan = date('Y-m-d H:i:s');
$status = "TERKIRIM";

// Handle image upload
$foto_bukti = "Tidak ada foto";
if (isset($_FILES['foto_bukti']) && $_FILES['foto_bukti']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_ext = strtolower(pathinfo($_FILES['foto_bukti']['name'], PATHINFO_EXTENSION));
    $new_filename = 'laporan_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;

    if (move_uploaded_file($_FILES['foto_bukti']['tmp_name'], $upload_dir . $new_filename)) {
        $foto_bukti = $new_filename;
    }
}

if (empty($nik) || empty($subjek)) {
    echo json_encode(["status" => "error", "message" => "NIK dan Subjek tidak boleh kosong."]);
    exit();
}

try {
    $query = "INSERT INTO laporan (nik, subjek, kategori, detail, lokasi, foto_bukti, tanggal_laporan, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", $nik, $subjek, $kategori, $detail, $lokasi, $foto_bukti, $tanggal_laporan, $status);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Laporan berhasil dikirim"]);
    }
    else {
        echo json_encode(["status" => "error", "message" => "Gagal mengirim laporan: " . mysqli_error($conn)]);
    }
}
catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>