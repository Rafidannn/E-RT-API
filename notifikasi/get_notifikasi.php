<?php
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include_once '../config/database.php';

$notifications = [];
$errors = [];

try {
    // 1. Iuran (Riwayat Keseluruhan)
    try {
        $q1 = "SELECT i.*, COALESCE(u.nama, 'Warga') as nama FROM iuran i LEFT JOIN users u ON i.id_user = u.id_user ORDER BY i.tanggal_bayar DESC LIMIT 15";
        $res1 = $conn->query($q1);
        if($res1 && $res1->num_rows > 0) {
            while($r = $res1->fetch_assoc()) {
                $nama = $r['nama'] ?? 'Warga';
                $jenis = rtrim(($r['jenis_iuran'] ?? 'Iuran') . " " . ($r['bulan'] ?? ''));
                $is_pending = (strtolower($r['status'] ?? '') === 'menunggu' || strtolower($r['status'] ?? '') === 'pending');
                $notifications[] = [
                    'id' => 'iuran_'.$r['id_iuran'],
                    'tipe' => 'IURAN',
                    'judul' => 'Pembayaran ' . $jenis,
                    'deskripsi' => "$nama dlm proses bayar. Status: " . ucfirst($r['status'] ?? ''),
                    'created_at' => $r['tanggal_bayar'] ?? $r['created_at'] ?? date('Y-m-d H:i:s'),
                    'has_action' => $is_pending
                ];
            }
        }
    } catch (\Throwable $e) {}

    // 2. Surat Pengantar
    try {
        $q2 = "SELECT p.*, w.nama FROM surat_pengantar p LEFT JOIN warga w ON p.nik = w.nik ORDER BY p.id_surat DESC LIMIT 15";
        $res2 = $conn->query($q2);
        if($res2 && $res2->num_rows > 0) {
            while($r = $res2->fetch_assoc()) {
                $nama = $r['nama'] ?? 'Pemohon';
                $is_pending = (strtoupper($r['status'] ?? '') === 'MENUNGGU' || strtoupper($r['status'] ?? '') === 'PENDING');
                $notifications[] = [
                    'id' => 'surat_'.$r['id_surat'],
                    'tipe' => 'ADMINISTRASI',
                    'judul' => 'Surat Pengantar',
                    'deskripsi' => "$nama - " . ($r['keperluan'] ?? '-') . " (" . ucfirst($r['status'] ?? '') . ")",
                    'created_at' => $r['tanggal_pengajuan'] ?? date('Y-m-d H:i:s'),
                    'has_action' => $is_pending
                ];
            }
        }
    } catch (\Throwable $e) {}

    // 3. Verifikasi Warga Baru
    try {
        $q3 = "SELECT u.*, u.nama as nama_lengkap FROM users u ORDER BY u.created_at DESC LIMIT 15";
        $res3 = $conn->query($q3);
        if($res3 && $res3->num_rows > 0) {
            while($r = $res3->fetch_assoc()) {
                $nama = $r['nama_lengkap'] ?? $r['nama'] ?? 'Warga Baru';
                $is_pending = ($r['is_verified'] == 0);
                $notifications[] = [
                    'id' => 'user_'.$r['id_user'],
                    'tipe' => 'VERIFIKASI',
                    'judul' => 'Registrasi Sistem',
                    'deskripsi' => "$nama telah daftar. " . ($is_pending ? "Menunggu Verifikasi" : "Telah Aktif"),
                    'created_at' => $r['created_at'] ?? date('Y-m-d H:i:s'),
                    'has_action' => $is_pending
                ];
            }
        }
    } catch (\Throwable $e) {}

    // 4. Pengumuman / Info RT
    try {
        $q4 = "SELECT * FROM pengumuman ORDER BY tanggal DESC LIMIT 10";
        $res4 = $conn->query($q4);
        if($res4) {
            while($r = $res4->fetch_assoc()) {
                $notifications[] = [
                    'id' => 'pengumuman_'.$r['id_pengumuman'],
                    'tipe' => 'PENGUMUMAN PENTING',
                    'judul' => $r['judul'],
                    'deskripsi' => $r['isi'],
                    'created_at' => $r['tanggal'] ?? date('Y-m-d H:i:s'),
                    'has_action' => true,
                    'action_label' => 'Lihat'
                ];
            }
        }
    } catch (\Throwable $e) { $errors[] = "Pengumuman: " . $e->getMessage(); }

    // 5. Jumantik
    try {
        $q5 = "SELECT j.*, COALESCE(u.nama, 'Petugas') as nama FROM jumantik j LEFT JOIN users u ON j.petugas = u.id_user ORDER BY j.created_at DESC LIMIT 10";
        $res5 = $conn->query($q5);
        if($res5 && $res5->num_rows > 0) {
            while($r = $res5->fetch_assoc()) {
                $petugas = $r['nama'] ?? 'Petugas';
                $status_jentik = (strtolower($r['status_jentik'] ?? '') == 'ada') ? 'Terdapat jentik nyamuk' : 'Aman (Tidak ditemukan jentik)';
                $notifications[] = [
                    'id' => 'jumantik_'.$r['id_jumantik'],
                    'tipe' => 'KESEHATAN',
                    'judul' => 'Pengecekan Jumantik',
                    'deskripsi' => "Oleh $petugas. Hasil: $status_jentik.",
                    'created_at' => $r['created_at'] ?? date('Y-m-d H:i:s'),
                    'has_action' => false
                ];
            }
        }
    } catch (\Throwable $e) {}

    usort($notifications, function($a, $b) {
        $tA = strtotime($a['created_at'] ?? '2000-01-01');
        $tB = strtotime($b['created_at'] ?? '2000-01-01');
        return $tB <=> $tA;
    });

} catch (\Throwable $e) { }

echo json_encode([
    "status" => "success",
    "data" => $notifications
]);
?>
