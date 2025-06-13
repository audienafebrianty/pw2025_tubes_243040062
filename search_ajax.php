<?php
include 'koneksi.php';

$keyword = $_GET['keyword'] ?? '';

if ($keyword == "") {
    $query = "SELECT destinations.*, categories.name AS category_name 
              FROM destinations 
              JOIN categories ON destinations.category_id = categories.id
              ORDER BY destinations.name ASC";
} else {
    $query = "SELECT destinations.*, categories.name AS category_name 
              FROM destinations 
              JOIN categories ON destinations.category_id = categories.id
              WHERE destinations.name LIKE '%$keyword%'
              ORDER BY destinations.name ASC";
}

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<a href='detail.php?id=" . urlencode($row['id']) . "' class='text-decoration-none text-white'>";
    echo "<div class='destinasi-card' style='border:1px solid #ccc; padding:10px; margin-bottom:10px; width:400px'>";
    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
    echo "<img src='img/" . htmlspecialchars($row['image']) . "' width='100%'><br>";
    echo "<small><b>Kategori:</b> " . htmlspecialchars($row['category_name']) . "</small><br>";
    echo "<small><b>Lokasi:</b> " . htmlspecialchars($row['location']) . "</small>";
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
    echo "</div>";
    echo "</a>";
}
