<?php
ob_start();
$_SERVER['REQUEST_METHOD'] = 'GET';
include __DIR__ . '/notifikasi/get_notifikasi.php';
$json = ob_get_clean();
file_put_contents(__DIR__ . '/output.json', $json);
echo "Written output.json";
?>
