<?php
include '../config/database.php';
include '../response.php';

$query = "
SELECT p.id_pengumuman, p.judul, p.isi, p.tanggal,
       u.nama AS pembuat
FROM pengumuman p
LEFT JOIN users u ON p.dibuat_oleh = u.id_user
ORDER BY p.created_at DESC
";

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

response(true, "Data pengumuman", $data);
