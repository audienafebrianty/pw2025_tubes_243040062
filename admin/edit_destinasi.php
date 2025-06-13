<?php
include '../koneksi.php';

$id = $_GET['id'];

$query = "SELECT * FROM destinasi WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    if ($_FILES['gambar']['name']) {
        $gambarBaru = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = "../img/";

        $target_file = $folder . basename($gambarBaru);
        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $i = 1;
        while (file_exists($target_file)) {
            $gambarBaru = pathinfo($_FILES['gambar']['name'], PATHINFO_FILENAME) . "_$i." . $ext;
            $target_file = $folder . $gambarBaru;
            $i++;
        }

        move_uploaded_file($tmp, $target_file);
    } else {
        $gambarBaru = $data['gambar'];
    }

    $update = "UPDATE destinasi SET 
        nama = '$nama', 
        kategori = '$kategori', 
        deskripsi = '$deskripsi', 
        gambar = '$gambarBaru' 
        WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Destinasi berhasil diupdate'); window.location='dashboard.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Destinasi - Lalaloka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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

        .btn-warning {
            background-color: #ffa726;
            border-color: #ffa726;
        }

        .btn-warning:hover {
            background-color: #fb8c00;
            border-color: #fb8c00;
        }

        label {
            font-weight: 500;
        }

        /* Footer style */
        footer {
            background: linear-gradient(to right, rgb(255, 212, 95), rgb(238, 87, 0));
        }

        .footer-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-link:hover {
            color: #f7e8d4;
            text-decoration: underline;
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
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-map"></i> Destinasi</a></li>
                <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-pencil-square"></i> Edit Destinasi</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <h3 class="mb-4 text-center"><i class="bi bi-pencil-square text-warning"></i> Edit Destinasi</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label"><i class="bi bi-geo-alt-fill"></i> Nama Destinasi</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label"><i class="bi bi-tags-fill"></i> Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                $kategori_list = ["Pantai", "Budaya", "Pegunungan", "Kuliner", "Air Terjun", "Religi", "Taman Hiburan", "Pemandangan Alam", "Desa Wisata", "Petualangan"];
                                foreach ($kategori_list as $kat) {
                                    $selected = ($data['kategori'] == $kat) ? "selected" : "";
                                    echo "<option $selected>$kat</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label"><i class="bi bi-chat-left-dots-fill"></i> Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label"><i class="bi bi-image-fill"></i> Gambar (biarkan kosong jika tidak ingin mengubah)</label>
                            <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                            <div class="mt-2">
                                <small>Gambar saat ini:</small><br>
                                <img src="../img/<?= htmlspecialchars($data['gambar']) ?>" alt="Gambar Saat Ini" class="img-thumbnail mt-1" style="width: 150px;">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-warning px-4"><i class="bi bi-save2"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-4 mt-5">
        <div class="container">
            <p class="mb-2">&copy; <?= date('Y') ?> Lalaloka Bali. All rights reserved.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="https://www.instagram.com/lalaloka.bali" target="_blank" class="footer-link">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                &nbsp; | &nbsp;
                <a href="https://www.facebook.com/lalalokabali" target="_blank" class="footer-link">
                    <i class="bi bi-facebook"></i> Facebook
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>