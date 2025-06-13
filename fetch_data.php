<?php
include 'koneksi.php';

$keyword = $_POST['keyword'] ?? '';
$kategori = $_POST['kategori'] ?? '';

$sql = "SELECT * FROM destinasi WHERE 1";
if ($keyword != '') {
    $sql .= " AND nama LIKE '%$keyword%'";
}
if ($kategori != '') {
    $sql .= " AND kategori = '$kategori'";
}
$sql .= " ORDER BY id DESC";

$query = mysqli_query($conn, $sql);

echo '<table border="1" cellpadding="10">';
echo '
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Deskripsi</th>
    <th>Gambar</th>
    <th>Aksi</th>
</tr>';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    echo "<tr>
        <td>$no</td>
        <td>{$row['nama']}</td>
        <td>{$row['kategori']}</td>
        <td>{$row['deskripsi']}</td>
        <td><img src='img/{$row['gambar']}' width='100'></td>
        <td>
            <a href='edit_destinasi.php?id={$row['id']}'>Edit</a> |
            <a href='hapus_destinasi.php?id={$row['id']}' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
        </td>
    </tr>";
    $no++;
}

if (mysqli_num_rows($query) == 0) {
    echo '<tr><td colspan="6">Data tidak ditemukan</td></tr>';
}

echo '</table>';
