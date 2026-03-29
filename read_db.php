<?php
require 'config/database.php';
$res = mysqli_query($conn, "SELECT * FROM jumantik ORDER BY id_jumantik DESC LIMIT 3");
$data = [];
while($r = mysqli_fetch_assoc($res)) {
   $data[] = $r;
}
echo json_encode($data, JSON_PRETTY_PRINT);
?>
