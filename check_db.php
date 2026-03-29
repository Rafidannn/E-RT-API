<?php
header("Content-Type: application/json");
include_once 'config/database.php';

$res = [];
try {
    $q = $conn->query("SHOW COLUMNS FROM pengumuman");
    $res['schema'] = $q ? $q->fetch_all(MYSQLI_ASSOC) : mysqli_error($conn);
    $q2 = $conn->query("SELECT * FROM pengumuman LIMIT 3");
    $res['data'] = $q2 ? $q2->fetch_all(MYSQLI_ASSOC) : mysqli_error($conn);
} catch (Exception $e) {
    $res['error'] = $e->getMessage();
}

$json = json_encode($res);
file_put_contents('result.json', $json);
echo "Written to result.json\n";
?>
