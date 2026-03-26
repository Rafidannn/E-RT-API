<?php
require_once 'config/database.php';

$res = mysqli_query($conn, "SELECT id_jumantik, id_keluarga, status_jentik, wadah, catatan, foto, tanggal, petugas FROM jumantik ORDER BY id_jumantik DESC LIMIT 5");
$data = [];
while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
}
echo json_encode($data);
?>
