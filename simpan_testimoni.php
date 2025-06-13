<?php
session_start();
require 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Proses hanya jika metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap dan validasi data
    $user_id = $_POST['user_id'] ?? null;
    $destination_id = $_POST['destination_id'] ?? null;
    $comment = trim($_POST['comment'] ?? '');
    $rating = $_POST['rating'] ?? null;

    // Validasi data dasar
    if (!$user_id || !$destination_id || !$comment || !$rating) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='index.php#komentar';</script>";
        exit;
    }

    // Sanitasi tambahan jika perlu
    $comment = htmlspecialchars($comment);

    // Siapkan dan eksekusi query insert
    $stmt = $conn->prepare("INSERT INTO testimonials (user_id, destination_id, comment, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisi", $user_id, $destination_id, $comment, $rating);

    if ($stmt->execute()) {
        $stmt->close();
        echo "<script>alert('Komentar berhasil disimpan!'); window.location.href='index.php#komentar';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan komentar!'); window.location.href='index.php#komentar';</script>";
        exit;
    }
} else {
    // Bukan akses POST
    echo "<script>alert('Akses tidak sah!'); window.location.href='index.php';</script>";
    exit;
}
