<?php
require '../koneksi.php';

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';

// Query dasar
$query = "SELECT * FROM destinasi WHERE 1";

// Tambahkan pencarian jika ada keyword
if (!empty($keyword)) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query .= " AND nama LIKE '%$keyword%'";
}

// Tambahkan filter kategori jika dipilih
if (!empty($kategori)) {
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $query .= " AND kategori = '$kategori'";
}

$query .= " ORDER BY id DESC";

$result = mysqli_query($conn, $query);
$no = 1;

if (mysqli_num_rows($result) > 0) {
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
                <a href='hapus_destinasi.php?id={$row['id']}' class='btn btn-sm btn-danger' 
                   onclick='return confirm(\"Yakin ingin menghapus destinasi ini?\")'>
                   <i class='bi bi-trash'></i> Hapus
                </a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Tidak ada data ditemukan.</td></tr>";
}
