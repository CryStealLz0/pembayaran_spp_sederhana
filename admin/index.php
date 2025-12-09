<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

// Hitung total siswa
$total_siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM siswa"))['jml'];

// Hitung total pembayaran
$total_bayar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah_bayar),0) AS total FROM pembayaran"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - SPP</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <!-- NAVBAR ADMIN -->
    <div class="navbar">
        <div class="navbar-brand">Pembayaran SPP</div>
        <div class="navbar-menu">
            <span class="navbar-hello">
                Halo, <?= htmlspecialchars($_SESSION['username']); ?>
            </span>
            <a href="index.php" class="active">Dashboard</a>
            <a href="siswa_tampil.php">Data Siswa</a>
            <a href="pembayaran_tampil.php">Data Pembayaran</a>
            <a href="laporan.php">Laporan</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="page-wrapper">

        <!-- Header Dashboard -->
        <h1 class="page-title" style="margin-bottom: 4px;">
            Dashboard Admin
        </h1>
        <p class="dashboard-subtitle">
            Selamat datang di Aplikasi Pembayaran SPP Sederhana. Kelola data siswa, tagihan, dan pembayaran dari satu tempat.
        </p>

        <!-- Card Ringkasan -->
        <div class="card" style="margin-top: 10px;">
            <span class="pill-label">Ringkasan Data</span>

            <div class="card-stat">
                <div class="card-stat-title">Total Siswa</div>
                <div class="card-stat-value">
                    <?= number_format($total_siswa, 0, ',', '.'); ?>
                </div>
            </div>

            <div class="card-stat">
                <div class="card-stat-title">Total Pembayaran Masuk</div>
                <div class="card-stat-value">
                    Rp <?= number_format($total_bayar, 0, ',', '.'); ?>
                </div>
            </div>
        </div>

        <!-- Quick Menu / Aksi Cepat -->
        <div class="card">
            <h2 style="font-size: 16px; margin-bottom: 8px;">Aksi Cepat</h2>
            <p class="dashboard-subtitle" style="margin-bottom: 8px;">
                Pilih menu untuk mulai mengelola data:
            </p>

            <ul class="dashboard-links">
                <li>
                    <a href="siswa_tampil.php">
                        👨‍🎓 Kelola Data Siswa
                        <span>Tambah, ubah, dan hapus data siswa.</span>
                    </a>
                </li>
                <li>
                    <a href="pembayaran_tampil.php">
                        💰 Kelola Data Pembayaran
                        <span>Catat pembayaran baru dan lihat histori.</span>
                    </a>
                </li>
                <li>
                    <a href="laporan.php">
                        📊 Laporan Pembayaran SPP
                        <span>Cetak atau lihat rekap pembayaran per periode.</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

</body>
</html>
