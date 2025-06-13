<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan.'); window.location='index.php';</script>";
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM destinations WHERE id = $id");
$data = mysqli_fetch_assoc($result);

// Ambil komentar dan rating
$comments = mysqli_query($conn, "SELECT * FROM testimonials WHERE destination_id = $id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['name']) ?> - Lalaloka Bali</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="img/logo_lalaloka.png">
    <style>
        body {
            background: linear-gradient(to bottom, #f7a440, rgb(248, 225, 149));
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .navbar {
            background: linear-gradient(to right, rgb(255, 212, 95), rgb(241, 120, 7));
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #ff5722;
        }

        .card-header {
            background-color: #ff7043;
            color: white;
        }

        .rating i {
            color: #ffd700;
        }

        .logo-img {
            height: 60px;
        }

        .btn-kembali {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-kembali:hover {
            text-decoration: underline;
        }

        footer {
            background: linear-gradient(to right, rgb(255, 212, 95), rgb(238, 87, 0));
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
            color: #f7e8d4;
            /* warna putih kekuningan saat hover (opsional) */
        }
    </style>



</head>

<body>

    <!-- Navbar -->
    <nav class="navbar d-flex justify-content-between px-4 py-2">
        <img src="img/logo_lalaloka.png" alt="Lalaloka Bali" class="logo-img">
        <a href="index.php" class="btn-kembali"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
    </nav>

    <!-- Konten Utama -->
    <div class="container py-5">
        <div class="card mb-5">
            <img src="img/<?= htmlspecialchars($data['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($data['name']) ?>">
            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($data['name']) ?></h3>
                <p><i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($data['location']) ?></p>
                <p><i class="bi bi-info-circle-fill text-primary"></i> <?= nl2br(htmlspecialchars($data['description'])) ?></p>
            </div>
        </div>

        <!-- Komentar dan Rating -->
        <div class="card mb-5">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Ulasan Pengunjung</h5>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($comments) > 0): ?>
                    <?php while ($comment = mysqli_fetch_assoc($comments)): ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong><i class="bi bi-person-circle"></i> User #<?= $comment['user_id'] ?></strong>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi <?= $i <= $comment['rating'] ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="mb-1"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                            <small class="text-muted"><?= $comment['created_at'] ?></small>
                            <hr>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted">Belum ada ulasan. Jadilah yang pertama memberikan komentar!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-4">
        <div class="container">
            <p class="mb-2">&copy; <?= date('Y') ?> Lalaloka Bali. All rights reserved.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="https://www.instagram.com/lalaloka.bali" target="_blank">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                &nbsp; | &nbsp;
                <a href="https://www.facebook.com/lalalokabali" target="_blank">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>