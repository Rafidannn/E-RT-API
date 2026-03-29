<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");
try {
    include '../config/database.php';
    $nik = $_GET['nik'] ?? '';
    if(!$nik) throw new Exception("NIK is required");

    // 1. Dapatkan id_keluarga
    $stmt1 = $conn->prepare("SELECT id_keluarga FROM warga WHERE nik = ? LIMIT 1");
    $stmt1->bind_param("s", $nik);
    $stmt1->execute();
    $res1 = $stmt1->get_result();
    if($res1->num_rows == 0) throw new Exception("Data warga tidak ditemukan");
    $row1 = $res1->fetch_assoc();
    $id_keluarga = $row1['id_keluarga'];

    if(!$id_keluarga) throw new Exception("Warga dengan NIK ini belum terkait dengan Kartu Keluarga manapun di sistem.");

    // 2. Dapatkan Data Keluarga
    $stmt2 = $conn->prepare("SELECT no_kk, alamat_lengkap, rt_rw, status_ekonomi, id_kepala_keluarga FROM keluarga WHERE id_keluarga = ? LIMIT 1");
    $stmt2->bind_param("i", $id_keluarga);
    $stmt2->execute();
    $keluargaData = $stmt2->get_result()->fetch_assoc();
    
    if(!$keluargaData) throw new Exception("Data keluarga tidak ditemukan");

    // Cari nama kepala keluarga
    $nama_kepala = "Belum Terdaftar";
    if($keluargaData['id_kepala_keluarga']) {
         $stmtK = $conn->prepare("SELECT nama FROM warga WHERE id_warga = ? LIMIT 1");
         $stmtK->bind_param("i", $keluargaData['id_kepala_keluarga']);
         $stmtK->execute();
         $resK = $stmtK->get_result();
         if($resK->num_rows > 0) {
             $nama_kepala = $resK->fetch_assoc()['nama'];
         }
    }

    // 3. Dapatkan List Anggota
    $stmt3 = $conn->prepare("SELECT id_warga, nama, nik, jenis_kelamin, status_kesehatan_khusus, bpjs_aktif, status_perkawinan FROM warga WHERE id_keluarga = ?");
    $stmt3->bind_param("i", $id_keluarga);
    $stmt3->execute();
    $res3 = $stmt3->get_result();
    
    $anggotaList = [];
    $total_bpjs = 0;
    $total_lansia = 0;
    
    $isIstriFound = false;
    while($r = $res3->fetch_assoc()) {
        $role = "ANGGOTA KELUARGA";
        
        if($keluargaData['id_kepala_keluarga'] == $r['id_warga']) {
            $role = "KEPALA KELUARGA";
        } else if($r['jenis_kelamin'] == 'P' && $r['status_perkawinan'] == 'kawin' && !$isIstriFound) {
            $role = "ISTRI"; 
            $isIstriFound = true;
        } else {
            $role = "ANGGOTA KELUARGA";
        }

        if($r['bpjs_aktif'] == 1) $total_bpjs++;
        if($r['status_kesehatan_khusus'] == 'lansia') $total_lansia++;

        $anggotaList[] = [
            'id' => $r['id_warga'],
            'nama' => $r['nama'],
            'nik' => $r['nik'],
            'jk' => $r['jenis_kelamin'],
            'status_khusus' => $r['status_kesehatan_khusus'],
            'bpjs' => $r['bpjs_aktif'],
            'role' => $role
        ];
    }

    $response = [
        "status" => "success",
        "keluarga" => [
            "no_kk" => $keluargaData['no_kk'],
            "kepala_keluarga" => $nama_kepala,
            "alamat" => $keluargaData['alamat_lengkap'],
            "rt_rw" => $keluargaData['rt_rw'],
            "status_ekonomi" => ucfirst($keluargaData['status_ekonomi']),
            "stats" => [
                "anggota" => count($anggotaList),
                "bpjs" => $total_bpjs,
                "lansia" => $total_lansia
            ]
        ],
        "anggota" => $anggotaList
    ];

    echo json_encode($response);
} catch (\Throwable $e) {
    echo json_encode(["status"=>"error", "message"=>$e->getMessage()]);
}
?>
