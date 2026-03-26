<?php
header("Content-Type: application/json");
include '../config/database.php';

// Ambil user yang rolenya admin doang sesuai request
$query = "SELECT id_user, nama FROM users WHERE role = 'admin'";
$result = mysqli_query($conn, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) { $data[] = $row; }

echo json_encode(["status" => true, "data" => $data]);
?>