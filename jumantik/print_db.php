<?php
require_once '../config/database.php';
$res = mysqli_query($conn, "SELECT id_jumantik, foto FROM jumantik ORDER BY id_jumantik DESC LIMIT 5");
while($r = mysqli_fetch_assoc($res)) {
    echo "ID: " . $r['id_jumantik'] . " - FOTO: " . (empty($r['foto']) ? 'EMPTY' : $r['foto']) . "\n";
}
?>
