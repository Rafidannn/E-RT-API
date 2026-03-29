<?php
header("Content-Type: text/plain");
require_once 'config/database.php';

$sql = "ALTER TABLE jumantik ADD COLUMN wadah VARCHAR(100) DEFAULT NULL, ADD COLUMN catatan TEXT DEFAULT NULL, ADD COLUMN foto VARCHAR(200) DEFAULT NULL;";

if (mysqli_query($conn, $sql)) {
    echo "SUCCESS_ALTER_TABLE\n";
} else {
    echo "ERROR_ALTER_TABLE: " . mysqli_error($conn) . "\n";
}

$res = mysqli_query($conn, "DESCRIBE jumantik");
while($r = mysqli_fetch_assoc($res)) {
   echo $r['Field'] . "\n";
}
?>
