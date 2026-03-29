<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

try {
    include '../config/database.php';
    $nik = $_GET['nik'] ?? '';
    if (!$nik) throw new Exception("NIK required");

    // Data lengkap warga + user + keluarga
    $sql = "SELECT 
                w.nama, w.nik, w.tempat_lahir, w.tanggal_lahir,
                w.jenis_kelamin, w.pendidikan, w.pekerjaan,
                w.status_perkawinan, w.status_kesehatan_khusus, w.bpjs_aktif,
                u.role, u.is_verified, u.created_at AS bergabung_sejak,
                k.no_kk, k.alamat_lengkap AS alamat, k.rt_rw, k.status_ekonomi,
                (SELECT nama FROM warga WHERE id_warga = k.id_kepala_keluarga) AS nama_kepala
            FROM warga w
            LEFT JOIN users u ON w.nik = u.nik
            LEFT JOIN keluarga k ON w.id_keluarga = k.id_keluarga
            WHERE w.nik = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row) throw new Exception("Data warga tidak ditemukan");

    // Hitung statistik aktivitas
    $statSql = "SELECT
        (SELECT COUNT(*) FROM laporan WHERE nik = ?) AS total_laporan,
        (SELECT COUNT(*) FROM laporan WHERE nik = ? AND status = 'SELESAI') AS laporan_selesai,
        (SELECT COUNT(*) FROM surat_pengantar WHERE nik = ?) AS total_surat,
        (SELECT COUNT(*) FROM surat_pengantar WHERE nik = ? AND status = 'DISETUJUI') AS surat_disetujui,
        (SELECT COUNT(*) FROM iuran i
            JOIN users u ON i.id_user = u.id_user
            WHERE u.nik = ? AND i.status = 'lunas') AS iuran_lunas";

    $stmtStat = $conn->prepare($statSql);
    $stmtStat->bind_param("sssss", $nik, $nik, $nik, $nik, $nik);
    $stmtStat->execute();
    $stats = $stmtStat->get_result()->fetch_assoc();

    // Status iuran bulan ini
    $bulanIni = date('Y-m');
    $sqlIuran = "SELECT i.status FROM iuran i
                 JOIN users u ON i.id_user = u.id_user
                 WHERE u.nik = ? AND i.bulan LIKE CONCAT(?, '%')
                 ORDER BY i.created_at DESC LIMIT 1";
    $stmtIuran = $conn->prepare($sqlIuran);
    $stmtIuran->bind_param("ss", $nik, $bulanIni);
    $stmtIuran->execute();
    $iuranRow = $stmtIuran->get_result()->fetch_assoc();
    $statusIuranBulanIni = $iuranRow ? $iuranRow['status'] : 'belum';

    echo json_encode([
        "status"  => "success",
        "profil"  => $row,
        "stats"   => $stats,
        "iuran_bulan_ini" => $statusIuranBulanIni
    ]);

} catch (\Throwable $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
