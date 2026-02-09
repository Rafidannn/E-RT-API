<?php
include "../config/database.php";
include "../response.php";

$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

$query = mysqli_query($conn,
    "SELECT * FROM users WHERE nik='$nik' LIMIT 1"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    response(false, "NIK tidak ditemukan");
}

if (!password_verify($password, $user['password'])) {
    response(false, "Password salah");
}

unset($user['password']);
response(true, "Login berhasil", $user);
