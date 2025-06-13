<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM kontak WHERE id = $id");
}

header('Location: pesan_kontak.php');
exit;
