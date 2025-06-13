<?php
include 'koneksi.php';

$id = $_GET['id'];


$get = mysqli_query($conn, "SELECT gambar FROM destinasi WHERE id = $id");
$data = mysqli_fetch_assoc($get);

if ($data && file_exists("img/" . $data['gambar'])) {
    unlink("img/" . $data['gambar']);
}

$hapus = "DELETE FROM destinasi WHERE id = $id";
if (mysqli_query($conn, $hapus)) {
    echo "<script>alert('Destinasi berhasil dihapus'); window.location='dashboard.php';</script>";
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
