<?php
include 'config/database.php';
$res = mysqli_query($conn, 'SHOW COLUMNS FROM pengumuman');
$out = '';
while($r = mysqli_fetch_assoc($res)) {
    $out .= print_r($r, true);
}
$res = mysqli_query($conn, 'SELECT * FROM pengumuman LIMIT 3');
while($r = mysqli_fetch_assoc($res)) {
    $out .= print_r($r, true);
}
file_put_contents(__DIR__ . '/schema_out.txt', $out);
?>
