<?php
session_start();
require '../koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM kontak ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Pesan Kontak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        /* Biar footer selalu di bawah */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            background-color: #fff8f0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1 0 auto;
            /* konten bisa meluas */
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(45deg, rgb(255, 198, 93), rgb(197, 54, 2), rgb(238, 209, 95));
        }

        .navbar-brand img {
            height: 55px;
            border-radius: 10px;
            margin-right: 10px;
        }

        /* Footer sticky */
        footer {
            flex-shrink: 0;
            background: linear-gradient(to right, rgb(224, 132, 4), rgb(189, 20, 8));
            color: white;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        /* Sosmed icon putih default */
        .sosmed-icons a {
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        /* Warna orange muda saat hover/focus/active */
        .sosmed-icons a:hover,
        .sosmed-icons a:focus,
        .sosmed-icons a:active {
            color: #ffb347;
            /* orange muda */
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <img src="../img/logo_lalaloka.png" alt="Logo" />
                <strong>Lalaloka Admin</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="bi bi-map"></i> Destinasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tambah_destinasi.php"><i class="bi bi-plus-circle"></i> Tambah Destinasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-envelope-paper"></i> Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- KONTEN -->
    <div class="container my-5 content-wrapper">
        <h2 class="mb-4"><i class="bi bi-envelope-paper-fill"></i> Daftar Pesan Pengunjung</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-warning text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Waktu Kirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
                            <td><?= date("d M Y, H:i", strtotime($row['created_at'])) ?></td>
                            <td class="text-center">
                                <a href="hapus_pesan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($result) === 0): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pesan masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-2">&copy; <?= date('Y') ?> Lalaloka Bali. All rights reserved.</p>
            <div class="sosmed-icons">
                <a href="https://www.instagram.com/lalaloka.bali" target="_blank" class="me-3" rel="noopener noreferrer">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                <a href="https://www.facebook.com/lalalokabali" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
            </div>
        </div>
    </footer>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>