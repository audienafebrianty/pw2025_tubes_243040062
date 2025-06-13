<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pw2025_tubes_243040062";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
