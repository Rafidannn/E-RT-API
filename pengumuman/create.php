<?php
include "../config/database.php";
include "../response.php";

$judul = $_POST['judul'];
$isi = $_POST['isi'];
$user_id = $_POST['user_id'];
$tanggal = date('Y-m-d');

mysqli_query($conn,
    "INSERT INTO pengumuman (judul, isi, tanggal, dibuat_oleh)
     VALUES ('$judul','$isi','$tanggal','$user_id')"
);

response(true, "Pengumuman ditambahkan");
