<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home User - SPP</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="navbar-brand">Pembayaran SPP</div>
        <div class="navbar-menu">
            <a href="../index.php">Beranda</a>
            <a href="index.php" class="active">User</a>
            <a href="../admin/login.php">Admin</a>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="card card-center">

            <!-- Badge kecil di atas judul -->
            <span class="pill-label">Mode User</span>

            <h1 class="page-title user-title">
                Aplikasi Pembayaran SPP Sederhana
            </h1>

            <p class="user-subtitle">
                Selamat datang di halaman user. Di sini Anda dapat melihat informasi
                pembayaran SPP dengan cepat tanpa harus login.
            </p>

            <ul class="menu-list menu-list-cards">
                <li class="menu-item">
                    <div class="menu-item-text">
                        <div class="menu-item-title">
                            📋 Daftar Siswa &amp; Status Pembayaran
                        </div>
                        <div class="menu-item-subtitle">
                            Lihat seluruh daftar siswa beserta status SPP tiap bulan.
                        </div>
                    </div>
                    <a href="daftar_siswa.php" class="btn btn-primary btn-sm" style="color: white;">
                        Buka
                    </a>
                </li>

                <li class="menu-item">
                    <div class="menu-item-text">
                        <div class="menu-item-title">
                            🔍 Cek Status SPP Berdasarkan NIS
                        </div>
                        <div class="menu-item-subtitle">
                            Masukkan NIS untuk mengecek apakah SPP sudah lunas atau belum.
                        </div>
                    </div>
                    <a href="cek_status.php" class="btn btn-outline btn-sm">
                        Cek
                    </a>
                </li>
            </ul>

            <p class="user-footer-text">
                Ingin mengelola data siswa dan pembayaran? 
                <a href="../admin/login.php">Login sebagai admin</a>
            </p>

        </div>
    </div>

</body>
</html>
