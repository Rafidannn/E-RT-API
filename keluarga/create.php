<?php
// Masukkan file koneksi dan fungsi respon
require_once '../config/database.php';
require_once '../response.php';

// Header agar bisa diakses oleh Flutter
header("Content-Type: application/json");

// Pastikan method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil data dari body request (JSON)
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi input minimal (No KK dan Alamat wajib ada)
    if (!empty($data['no_kk']) && !empty($data['alamat_lengkap'])) {
        
        $no_kk              = $data['no_kk'];
        $alamat_lengkap     = $data['alamat_lengkap'];
        $rt_rw              = $data['rt_rw'] ?? '';
        $status_ekonomi     = $data['status_ekonomi'] ?? 'mampu';
        $sumber_air         = $data['sumber_air'] ?? 'sumur';
        $memiliki_jamban    = $data['memiliki_jamban'] ?? 1; // 1 = Ya, 0 = Tidak
        $pengelolaan_sampah = $data['pengelolaan_sampah'] ?? 'diangkut';
        $memiliki_toga      = $data['memiliki_toga'] ?? 0;
        
            // Query Insert ke tabel keluarga
            $query = "INSERT INTO keluarga (
                    no_kk, 
                    alamat_lengkap, 
                    rt_rw, 
                    status_ekonomi, 
                    sumber_air, 
                    memiliki_jamban, 
                    pengelolaan_sampah, 
                    memiliki_toga
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($query);
        
        // Bind parameter (s = string, i = integer)
        $stmt->bind_param("sssssisi", 
            $no_kk, 
            $alamat_lengkap, 
            $rt_rw, 
            $status_ekonomi, 
            $sumber_air, 
            $memiliki_jamban, 
            $pengelolaan_sampah, 
            $memiliki_toga
        );

        if ($stmt->execute()) {
            // Menggunakan fungsi di response.php
            echo sendResponse(201, "Data Keluarga berhasil ditambahkan", [
                "id_keluarga" => $db->insert_id,
                "no_kk" => $no_kk
            ]);
        } else {
            echo sendResponse(500, "Gagal menyimpan data: " . $db->error);
        }

        $stmt->close();
    } else {
        echo sendResponse(400, "Data tidak lengkap. No KK dan Alamat wajib diisi.");
    }
} else {
    echo sendResponse(405, "Method tidak diizinkan. Gunakan POST.");
}
?>