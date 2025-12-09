<?php
session_start();
require "../config/koneksi.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $q = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = mysqli_query($koneksi, $q);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Untuk tugas, kita pakai plain password (di dunia nyata harus pakai hash)
        if ($password == $row['password']) {
            $_SESSION['admin_login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['id_admin'] = $row['id_admin'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - SPP</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="navbar-brand">Pembayaran SPP</div>
        <div class="navbar-menu">
            <a href="../index.php">Beranda</a>
            <a href="../user/index.php">User</a>
            <a href="login.php" class="active">Admin</a>
        </div>
    </div>

    <div class="login-page">
        <div class="login-box card">

            <span class="pill-label">Area Admin</span>

            <h1 class="page-title" style="font-size: 20px; margin-bottom: 4px; text-align:center;">
                Login Admin
            </h1>

            <p class="auth-subtitle">
                Masuk sebagai admin untuk mengelola data siswa, tagihan, dan pembayaran SPP.
            </p>

            <?php if (isset($error)) : ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        required
                        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <button type="submit" name="login" class="btn btn-primary" style="width:100%; margin-top:4px;">
                    Login
                </button>
            </form>

            <p class="auth-footer-text">
                Kembali ke halaman user? <a href="../user/index.php">Klik di sini</a>
            </p>
        </div>
    </div>

</body>
</html>
