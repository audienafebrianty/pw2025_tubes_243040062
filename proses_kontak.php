<?php
session_start();

// Include koneksi ke database
$host = "localhost";      // Ganti sesuai konfigurasi server lokal
$user = "root";           // Username default di Laragon
$password = "";           // Password default biasanya kosong di Laragon
$database = "pw2025_tubes_243040062";   // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan request berasal dari metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama  = htmlspecialchars(trim($_POST['nama']));
    $email = htmlspecialchars(trim($_POST['email']));
    $pesan = htmlspecialchars(trim($_POST['pesan']));

    // Validasi sederhana
    if (!empty($nama) && !empty($email) && !empty($pesan)) {
        // Siapkan query untuk insert ke database
        $stmt = $conn->prepare("INSERT INTO kontak (nama, email, pesan) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $pesan);

        // Eksekusi dan cek berhasil atau tidak
        if ($stmt->execute()) {
            // Kirim email ke admin setelah berhasil simpan pesan
            $to = "febriantyaudiena@gmail.com"; // Ganti dengan email admin asli
            $subject = "Pesan Baru dari Website Lalaloka";
            $message = "Anda menerima pesan baru dari:\n\n";
            $message .= "Nama: $nama\n";
            $message .= "Email: $email\n\n";
            $message .= "Pesan:\n$pesan\n";

            // Header email (dari siapa)
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";

            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['kontak_berhasil'] = "Pesan Anda berhasil dikirim dan kami sudah menginformasikan ke admin. Terima kasih telah menghubungi kami!";
            } else {
                // Email gagal terkirim, tapi pesan sudah tersimpan di DB
                $_SESSION['kontak_berhasil'] = "Pesan Anda berhasil dikirim, namun pemberitahuan ke admin gagal. Silakan hubungi kami jika diperlukan.";
            }
        } else {
            $_SESSION['kontak_gagal'] = "Gagal menyimpan pesan. Silakan coba lagi.";
        }

        $stmt->close();
    } else {
        $_SESSION['kontak_gagal'] = "Mohon lengkapi semua kolom sebelum mengirim.";
    }

    // Redirect kembali ke halaman index dengan anchor ke bagian kontak
    header("Location: index.php#kontak");
    exit;
} else {
    // Jika bukan dari form POST, kembalikan ke index
    header("Location: index.php");
    exit;
}

$conn->close();
