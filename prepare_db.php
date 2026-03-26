<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
require_once 'config/database.php';

$sql = "ALTER TABLE jumantik 
        ADD COLUMN wadah VARCHAR(100) DEFAULT NULL, 
        ADD COLUMN catatan TEXT DEFAULT NULL, 
        ADD COLUMN foto VARCHAR(200) DEFAULT NULL;";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => true, "message" => "Database berhasil diupdate kolom baru!"]);
} else {
    echo json_encode(["status" => false, "message" => mysqli_error($conn)]);
}
?>
