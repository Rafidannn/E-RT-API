<?php
include "../config/database.php";
include "../response.php";

$id_user = $_GET['id_user'];

$result = mysqli_query($conn,
    "SELECT * FROM iuran WHERE id_user='$id_user'"
);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

response(true, "Data iuran", $data);
