<?php
include 'config/database.php';
$log = "";
try {
    // 1. Iuran Pending
    $res1 = $conn->query("SELECT i.*, u.nama FROM iuran i LEFT JOIN users u ON i.id_user = u.id_user WHERE LOWER(i.status) = 'menunggu' OR LOWER(i.status) = 'pending'");
    if(!$res1) $log .= "Iuran error: " . $conn->error . "\n";
    else $log .= "Iuran rows: " . $res1->num_rows . "\n";

    // 2. Surat Pengantar Pending
    $res2 = $conn->query("SELECT p.*, w.nama FROM surat_pengantar p LEFT JOIN warga w ON p.nik = w.nik WHERE UPPER(p.status) = 'MENUNGGU'");
    if(!$res2) $log .= "Surat error: " . $conn->error . "\n";
    else $log .= "Surat rows: " . $res2->num_rows . "\n";

    // 3. User Pending (Verifikasi)
    $res3 = $conn->query("SELECT * FROM users WHERE is_verified = 0");
    if(!$res3) $log .= "Users error: " . $conn->error . "\n";
    else $log .= "Users rows: " . $res3->num_rows . "\n";

    // 4. Pengumuman Terbaru
    $res4 = $conn->query("SELECT * FROM pengumuman ORDER BY created_at DESC LIMIT 3");
    if(!$res4) $log .= "Pengumuman error: " . $conn->error . "\n";
    else $log .= "Pengumuman rows: " . $res4->num_rows . "\n";

    // 5. Jumantik Terbaru
    $res5 = $conn->query("SELECT j.*, u.nama FROM jumantik j LEFT JOIN users u ON j.petugas = u.id_user ORDER BY created_at DESC LIMIT 3");
    if(!$res5) $log .= "Jumantik error: " . $conn->error . "\n";
    else $log .= "Jumantik rows: " . $res5->num_rows . "\n";
} catch (Exception $e) {
    $log .= "Exception: " . $e->getMessage();
}
file_put_contents('test_log2.txt', $log);
?>
