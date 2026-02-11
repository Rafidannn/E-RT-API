<?php
include '../config/database.php';

$nik = $_POST['nik'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE nik = '$nik'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo json_encode(["status" => "success", "data" => $user]);
    } else {
        echo json_encode(["status" => "error", "message" => "Password salah"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "NIK tidak terdaftar"]);
}
?>