<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "../img/";

    $target_file = $folder . basename($gambar);
    $ext = pathinfo($target_file, PATHINFO_EXTENSION);

    $i = 1;
    while (file_exists($target_file)) {
        $gambar = pathinfo($_FILES['gambar']['name'], PATHINFO_FILENAME) . "_$i." . $ext;
        $target_file = $folder . $gambar;
        $i++;
    }

    if (move_uploaded_file($tmp, $target_file)) {
        $query = "INSERT INTO destinasi (nama, kategori, deskripsi, gambar) VALUES ('$nama', '$kategori', '$deskripsi', '$gambar')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Destinasi berhasil ditambahkan'); window.location='dashboard.php';</script>";
        } else {
            echo "Gagal menambahkan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Destinasi - Lalaloka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: rgb(255, 159, 80);
        }

        .navbar {
            background: linear-gradient(45deg, rgb(255, 198, 93), rgb(197, 54, 2), rgb(238, 209, 95));
        }

        .form-card {
            background-color: #fffefc;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .btn-primary {
            background-color: #ff7043;
            border-color: #ff7043;
        }

        .btn-primary:hover {
            background-color: #ff5722;
            border-color: #ff5722;
        }

        label {
            font-weight: 500;
        }

        footer {
            background-color: #d35400;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        footer a {
            color: #ffffff;
            text-decoration: none;
        }

        footer a:hover {
            color: #ffcc70;
            text-decoration: underline;
        }

        .sosmed-icons i {
            font-size: 1.2rem;
            margin: 0 8px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <img src="../img/logo_lalaloka.png" alt="Logo" style="height: 60px; margin-right: 10px; border-radius: 8px;">
                <strong>Dashboard Admin Lalaloka</strong>
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-map"></i> Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-plus-circle-fill"></i> Tambah Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="pesan_kontak.php"><i class="bi bi-envelope"></i> Pesan Kontak</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <h3 class="mb-4 text-center"><i class="bi bi-plus-circle text-warning"></i> Tambah Destinasi Baru</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label"><i class="bi bi-geo-alt-fill"></i> Nama Destinasi</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Pantai Kuta" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label"><i class="bi bi-tags-fill"></i> Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option>Pantai</option>
                                <option>Budaya</option>
                                <option>Pegunungan</option>
                                <option>Kuliner</option>
                                <option>Air Terjun</option>
                                <option>Religi</option>
                                <option>Taman Hiburan</option>
                                <option>Pemandangan Alam</option>
                                <option>Desa Wisata</option>
                                <option>Petualangan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label"><i class="bi bi-chat-left-dots-fill"></i> Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Tuliskan deskripsi destinasi..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label"><i class="bi bi-image-fill"></i> Gambar</label>
                            <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-upload"></i> Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?= date("Y") ?> Lalaloka Bali. All rights reserved.</p>
            <div class="sosmed-icons">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>