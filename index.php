<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}
require 'koneksi.php'; // koneksi database
$user_id = $_SESSION['user_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Live Search Destinasi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Poppins:wght@300;600&display=swap" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            font-family: 'Mountains of Christmas', cursive;
            background: url('./img/bgindx.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            padding-top: 80px;
        }

        .navbar {
            background-color: rgba(236, 98, 5, 0.8);
            backdrop-filter: blur(8px);
        }

        .navbar-brand img {
            height: 60px;
        }

        .nav-link {
            color: #fff !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .nav-link:hover {
            color: #ffb347 !important;
        }

        h2 {
            margin-bottom: 10px;
            color: #fff4e6;
        }

        input[type="text"] {
            width: 100%;
            max-width: 400px;
            padding: 12px;
            font-size: 16px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        #result {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
            margin-top: 30px;
            padding-bottom: 80px;
        }

        .destinasi-card {
            background: rgba(236, 98, 5, 0.95);
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 250px;
            font-family: "Lobster", cursive;
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .destinasi-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        footer {
            background-color: rgba(236, 98, 5, 0.8);
            color: #fff;
            padding: 30px 0;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        footer p {
            margin-bottom: 10px;
        }

        .social-icons a {
            color: #fff;
            margin: 0 12px;
            font-size: 1.0rem;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #ffb347;
            text-decoration: none;
        }

        @media (max-width: 576px) {
            .destinasi-card {
                max-width: 100%;
            }
        }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="./img/logo_lalaloka.png" alt="Lalaloka" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#destinasi">Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link" href="#komentar">Komentar</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="home" class="text-center py-5">
        <div class="container">
            <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
            <div class="card mx-auto" style="max-width: 900px; background-color: rgba(255,255,255,0.1); border: none; backdrop-filter: blur(5px); color: white;">
                <div class="card-body">
                    <h1 class="display-4 fw-bold mb-3" style="font-family: 'Mountains of Christmas', cursive;">
                        <i class="bi bi-airplane-engines"></i> Selamat Datang di Lalaloka Bali
                    </h1>
                    <p class="lead" style="font-family: 'Poppins', sans-serif;">
                        Temukan destinasi wisata impianmu di Bali — mulai dari keajaiban alam hingga kekayaan budaya yang memukau. Mari berpetualang bersama kami dan rasakan keajaiban setiap sudut Bali!
                    </p>
                    <a href="#destinasi" class="btn btn-warning mt-3">
                        <i class="bi bi-arrow-down-circle"></i> Jelajahi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Utama -->
    <div class="container mt-5 text-center">
        <!-- Tentang -->
        <section id="about" class="my-5">
            <div class="card mx-auto" style="max-width: 800px; background-color: rgba(255, 255, 255, 0.1); border: none; backdrop-filter: blur(5px);">
                <div class="card-body text-white">
                    <h4 class="card-title text-center mb-3" style="font-family: 'Poppins', sans-serif;">
                        <i class="bi bi-info-circle-fill"></i> Tentang Lalaloka
                    </h4>
                    <p class="card-text" style="font-family: 'Poppins', sans-serif;">
                        Lalaloka Bali adalah platform destinasi wisata yang menghadirkan keindahan Bali langsung ke genggaman Anda. Dari pantai eksotis hingga desa budaya, kami memberikan informasi terkini dan akurat untuk membantu Anda menemukan tempat terbaik untuk dikunjungi. Jelajahi Bali dengan cara yang lebih mudah, menyenangkan, dan penuh inspirasi.
                    </p>
                </div>
            </div>
        </section>

        <!-- Pencarian -->
        <div class="my-4" id="destinasi">
            <h3><i class="bi bi-search-heart-fill"></i> Cari Destinasi Wisata</h3>
            <input type="text" id="search" class="form-control mx-auto" placeholder="Ketik nama destinasi..." />
        </div>

        <!-- Hasil -->
        <div id="result"></div>
    </div>

    <!-- Kontak -->
    <section id="kontak" class="container my-5">
        <div class="card mx-auto" style="max-width:800px; background: rgba(255,255,255,0.1); backdrop-filter:blur(5px); color:#fff;">
            <div class="card-body">
                <h4 class="card-title text-center"><i class="bi bi-envelope-fill"></i> Hubungi Kami</h4>
                <p class="text-center" style="font-family: 'Poppins', sans-serif;">
                    Ingin bekerja sama, bertanya, atau memberikan masukan? Silakan hubungi kami melalui form di bawah ini atau melalui media sosial resmi kami.
                </p>
                <form action="proses_kontak.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan</label>
                        <textarea name="pesan" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-send"></i> Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Komentar dan Rating -->
    <section id="komentar" class="container my-5">
        <div class="card mx-auto" style="max-width:800px; background: rgba(255,255,255,0.1); backdrop-filter:blur(5px); color:#fff;">
            <div class="card-body">
                <h4 class="card-title"><i class="bi bi-chat-dots"></i> Komentar & Rating Anda</h4>
                <form action="simpan_testimoni.php" method="POST">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>" />
                    <div class="mb-3">
                        <label class="form-label">Destinasi ID</label>
                        <input type="number" name="destination_id" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select" required>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★</option>
                            <option value="3">★★★</option>
                            <option value="2">★★</option>
                            <option value="1">★</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-send-fill"></i> Kirim</button>
                </form>

                <hr class="bg-light" />

                <h5 class="mt-4">Ulasan Sebelumnya</h5>
                <?php
                $stmt = $conn->prepare("SELECT t.comment, t.rating, t.created_at, u.username FROM testimonials t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT 5");
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_assoc()):
                ?>
                    <div class="mt-3 text-start">
                        <strong><?= htmlspecialchars($row['username']) ?></strong>
                        <small class="text-muted">– <?= date('d M Y, H:i', strtotime($row['created_at'])) ?></small>
                        <div class="mb-1">
                            <?php for ($i = 0; $i < $row['rating']; $i++): ?>
                                <i class="bi bi-star-fill text-warning"></i>
                            <?php endfor; ?>
                            <?php for ($i = $row['rating']; $i < 5; $i++): ?>
                                <i class="bi bi-star text-warning"></i>
                            <?php endfor; ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
                        <hr class="bg-light" />
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?= date("Y"); ?> Lalaloka Bali. All rights reserved.</p>
            <div class="social-icons">
                <a href="https://www.instagram.com/lalaloka.bali" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                &nbsp; | &nbsp;
                <a href="https://www.facebook.com/lalalokabali" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
            </div>
        </div>
    </footer>

    <!-- Script AJAX untuk Live Search -->
    <script>
        $(document).ready(function() {
            function load_data(keyword = '') {
                $.ajax({
                    url: "search_ajax.php",
                    method: "GET",
                    data: {
                        keyword: keyword
                    },
                    success: function(data) {
                        $('#result').html(data);
                    }
                });
            }

            load_data();

            $('#search').on('keyup', function() {
                let keyword = $(this).val();
                load_data(keyword);
            });
        });
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>