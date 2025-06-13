<?php
session_start();
// if (!isset($_SESSION['admin'])) {
//     header("Location: login.php");
//     exit();
// }

require '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Lalaloka Bali</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
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

        .table thead {
            background: #ffe5b2;
        }

        .search-bar {
            background: #fff8f0;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #ff7043;
            border-color: #ff7043;
        }

        .btn-primary:hover {
            background-color: #ff5722;
            border-color: #ff5722;
        }

        .table img {
            border-radius: 10px;
        }

        footer {
            background: linear-gradient(to right, rgb(224, 132, 4), rgb(189, 20, 8));
            color: white;
        }

        footer a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
            color: rgb(238, 170, 101);
        }

        footer .bi {
            margin-right: 5px;
        }

        .sosmed-icons {
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo_lalaloka.png" alt="Logo" style="height: 60px; margin-right: 10px; border-radius: 8px;">
                <strong>Dashboard Admin Lalaloka</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-map"></i> Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="tambah_destinasi.php"><i class="bi bi-plus-circle"></i> Tambah Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="pesan_kontak.php"><i class="bi bi-envelope"></i> Pesan Kontak</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container">
        <div class="search-bar mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" id="search" class="form-control" placeholder="Cari nama destinasi...">
                </div>
                <div class="col-md-4">
                    <select id="kategoriFilter" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="Pantai">Pantai</option>
                        <option value="Budaya">Budaya</option>
                        <option value="Pegunungan">Pegunungan</option>
                        <option value="Kuliner">Kuliner</option>
                        <option value="Air Terjun">Air Terjun</option>
                        <option value="Religi">Religi</option>
                        <option value="Taman Hiburan">Taman Hiburan</option>
                        <option value="Pemandangan Alam">Pemandangan Alam</option>
                        <option value="Desa Wisata">Desa Wisata</option>
                        <option value="Petualangan">Petualangan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- TABEL DESTINASI -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="hasil">
                    <?php
                    $no = 1;
                    $result = mysqli_query($conn, "SELECT * FROM destinasi ORDER BY id DESC");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['kategori']}</td>
                        <td><img src='../img/{$row['gambar']}' width='100'></td>
                        <td>{$row['deskripsi']}</td>
                        <td class='text-center'>
                            <a href='edit_destinasi.php?id={$row['id']}' class='btn btn-sm btn-primary mb-1'>
                                <i class='bi bi-pencil'></i> Edit
                            </a><br>
                            <a href='hapus_destinasi.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus destinasi ini?\")'>
                                <i class='bi bi-trash'></i> Hapus
                            </a>
                        </td>
                    </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="text-center text-white mt-5 py-4">
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

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadData(keyword = '', kategori = '') {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: {
                    keyword: keyword,
                    kategori: kategori
                },
                success: function(data) {
                    $('#hasil').html(data);
                }
            });
        }

        $(document).ready(function() {
            loadData();

            $('#search').on('keyup', function() {
                let keyword = $(this).val();
                let kategori = $('#kategoriFilter').val();
                loadData(keyword, kategori);
            });

            $('#kategoriFilter').on('change', function() {
                let keyword = $('#search').val();
                let kategori = $(this).val();
                loadData(keyword, kategori);
            });
        });
    </script>

</body>

</html>