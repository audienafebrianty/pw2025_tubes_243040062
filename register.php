<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = 'user';

    $query = "INSERT INTO users (email, password, role) 
              VALUES ('$email', '$password', '$role')";
    mysqli_query($conn, $query);

    echo "<script>alert('Registrasi berhasil! Silakan login');window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register - Lalaloka</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <div class="register-container">
        <img src="./img/logo_lalaloka.png" alt="Logo Lalaloka" class="logo">
        <div class="form-card">
            <h2>Registrasi Akun</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Daftar</button>
            </form>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y'); ?> Lalaloka Bali. All rights reserved.</p>
        <div class="social-icons">
            <a href="https://www.instagram.com/lalaloka.bali" target="_blank">
                <i class="bi bi-instagram"></i> Instagram
            </a>
            &nbsp; | &nbsp;
            <a href="https://www.facebook.com/lalalokabali" target="_blank">
                <i class="bi bi-facebook"></i> Facebook
            </a>
        </div>
    </footer>

    <style>
        body {
  margin: 0;
  font-family: "Mountains of Christmas", serif;
  background: linear-gradient(135deg, #ffe259, #ffa751, #ff6a00);
  background-size: 400% 400%;
  animation: gradientBG 15s ease infinite;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

@keyframes gradientBG {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

.register-container {
  width: 100%;
  max-width: 400px;
  padding: 20px;
  box-sizing: border-box;
  position: relative;
}

.logo {
  width: 120px;
  position: fixed;
  top: 20px;
  left: 20px;
  z-index: 1000;
}

.form-card {
  background: rgba(255, 255, 255, 0.95);
  padding: 40px 30px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  text-align: center;
  margin-top: 80px;
}

h2 {
  margin-bottom: 20px;
  color: #e67d1c;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px 14px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-sizing: border-box;
  font-size: 14px;
}

button {
  width: 100%;
  padding: 12px;
  background: #ff6a00;
  border: none;
  color: white;
  font-size: 16px;
  font-weight: bold;
  border-radius: 10px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #e55b00;
}

p {
  margin-top: 15px;
  font-size: 14px;
}

a {
  color: #ff6a00;
  text-decoration: none;
  font-weight: 600;
}

footer {
  text-align: center;
  margin-top: 40px;
  color: #000000;
  position: fixed;
  bottom: 10px;
  left: 0;
  right: 0;
  font-size: 14px;
}

.social-icons {
  margin-top: 8px;
}

.social-icons a {
  margin: 0 8px;
  color: #000000;
  font-size: 18px;
  transition: color 0.3s ease;
}

.social-icons a:hover {
  color: #ff6a00;
}
    </style>
</body>

</html>