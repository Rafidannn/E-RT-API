<?php
header("Content-Type: application/json");
include '../config/database.php';

// Array untuk convert bulan Inggris ke Indonesia jika database lu pake bahasa Indo
$bulan_indo = [
    'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
    'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
    'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
    'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];

$bulan_eng = date('F');
$bulan_ini = $bulan_indo[$bulan_eng]; // Jadi 'Maret'
$tahun_ini = date('Y');

// 1. Hitung total uang masuk bulan ini
$sql_total = "SELECT SUM(nominal) as total FROM iuran WHERE bulan = '$bulan_ini' AND tahun = '$tahun_ini' AND status = 'lunas'";
$res_total = $conn->query($sql_total);
$row_total = $res_total->fetch_assoc();
$total_masuk = $row_total['total'] ?? 0;

// 2. Ambil list iuran terbaru (JOIN ke tabel keluarga buat dapetin NO KK)
$sql_recent = "SELECT i.*, k.no_kk 
               FROM iuran i 
               JOIN warga k ON i.id_keluarga = k.nik 
               ORDER BY i.tanggal_bayar DESC LIMIT 10";
// NOTE: Pastikan k.id_keluarga atau k.nik sesuai dengan relasi di tabel iuran lu!

$res_recent = $conn->query($sql_recent);
$recent_data = [];
if ($res_recent) {
    while($row = $res_recent->fetch_assoc()) {
        $recent_data[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "rekap" => [
        "total_bulan_ini" => number_format($total_masuk, 0, ',', '.'),
        "bulan" => $bulan_ini,
        "tahun" => $tahun_ini
    ],
    "recent_transactions" => $recent_data
]);
?>