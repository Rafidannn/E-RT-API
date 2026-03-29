<?php
$url = "http://localhost/api/notifikasi/get_notifikasi.php";
$context = stream_context_create(['http' => ['ignore_errors' => true]]);
$res = file_get_contents($url, false, $context);
file_put_contents('agent_output.txt', $res);
echo "Done";
?>
