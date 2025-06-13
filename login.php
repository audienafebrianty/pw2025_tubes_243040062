<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];


            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Lalaloka Bali</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Mountains+of+Christmas:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Mountains of Christmas", serif;
            background: url('./img/bglg.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 120px;
        }

        .login-box {
            background: rgba(255, 165, 100, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            margin: auto;
            margin-top: 120px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            background-color: rgb(228, 102, 0);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            width: 100%;
        }

        .btn-login:hover {
            background-color: rgb(224, 90, 0);
        }

        .login-footer {
            text-align: center;
            margin-top: 15px;
        }

        .login-footer a {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        footer {
            text-align: center;
            color: #fff;
            margin-top: 50px;
            font-size: 14px;
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
        }

        .social-icons {
            margin-top: 6px;
        }

        .social-icons a {
            margin: 0 8px;
            color: #fff;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #ff6a00;
        }
    </style>
</head>

<body>

    <img src="./img/logo_lalaloka.png" alt="Logo Lalaloka" class="logo">

    <div class="container">
        <div class="login-box">
            <h2>Login - Lalaloka Bali</h2>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger text-center"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-login">Login</button>
            </form>

            <div class="login-footer mt-3">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
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

</body>

</html>