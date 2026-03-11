<?php
ob_start();
header("Content-Type: application/json");
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

// Fungsi respon biar gak capek ngetik
function respon($status, $pesan) {
    ob_clean();
    echo json_encode(["status" => $status, "message" => $pesan]);
    exit;
}

// Validasi input: no_kk dan id_kepala_keluarga WAJIB ADA
if (!empty($data['no_kk']) && !empty($data['id_kepala_keluarga'])) {
    
    $no_kk = $data['no_kk'];
    $alamat = $data['alamat_lengkap'] ?? '';
    $rt_rw = $data['rt_rw'] ?? '';
    $ekonomi = !empty($data['status_ekonomi']) ? $data['status_ekonomi'] : 'pra-sejahtera';
    $air = $data['sumber_air'] ?? '';
    $jamban = (int)($data['memiliki_jamban'] ?? 0);
    $sampah = !empty($data['pengelolaan_sampah']) ? $data['pengelolaan_sampah'] : 'diangkut';    $toga = (int)($data['memiliki_toga'] ?? 0);
    $id_kepala = (int)$data['id_kepala_keluarga']; 

    // 1. Masukin data ke tabel keluarga
    $query = "INSERT INTO keluarga (no_kk, alamat_lengkap, rt_rw, status_ekonomi, sumber_air, memiliki_jamban, pengelolaan_sampah, memiliki_toga, id_kepala_keluarga) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssissi", $no_kk, $alamat, $rt_rw, $ekonomi, $air, $jamban, $sampah, $toga, $id_kepala);

    if ($stmt->execute()) {
        $new_id_keluarga = $conn->insert_id;

        // 2. KRUSIAL: Update si warga tersebut supaya id_keluarga-nya nyambung ke KK baru ini
        $query_update_warga = "UPDATE warga SET id_keluarga = ? WHERE id_warga = ?";
        $stmt_warga = $conn->prepare($query_update_warga);
        $stmt_warga->bind_param("ii", $new_id_keluarga, $id_kepala);
        $stmt_warga->execute();

        respon(true, "Keluarga Berhasil Ditambahkan!");
    } else {
        respon(false, "Gagal Insert Keluarga: " . $stmt->error);
    }
} else {
    respon(false, "Data No. KK dan Kepala Keluarga gak boleh kosong cok!");
}