<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

$siswa_q = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama ASC");

if (isset($_POST['simpan'])) {
    $id_siswa = (int) $_POST['id_siswa'];
    $bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
    $tahun = (int) $_POST['tahun'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $jumlah_bayar = (int) $_POST['jumlah_bayar'];
    $id_admin = $_SESSION['id_admin'];

    $q = "INSERT INTO pembayaran (id_siswa, bulan, tahun, tanggal_bayar, jumlah_bayar, id_admin)
          VALUES ('$id_siswa', '$bulan', '$tahun', '$tanggal_bayar', '$jumlah_bayar', '$id_admin')";
    mysqli_query($koneksi, $q);

    header("Location: pembayaran_tampil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pembayaran - SPP</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    <div class="navbar-brand">Pembayaran SPP</div>
    <div class="navbar-menu">
        <a href="index.php">Dashboard</a>
        <a href="siswa_tampil.php">Data Siswa</a>
        <a href="pembayaran_tampil.php" class="active">Data Pembayaran</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="page-wrapper">
    <div class="card card-form">
        <span class="pill-label">Input Pembayaran</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 8px;">
            Tambah Pembayaran
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 12px;">
            Lengkapi data berikut untuk mencatat pembayaran SPP baru.
        </p>

        <form method="post">
            <div class="form-group">
                <label for="id_siswa">Siswa</label>
                <select id="id_siswa" name="id_siswa" class="form-control" required>
                    <option value="">--Pilih Siswa--</option>
                    <?php while($s = mysqli_fetch_assoc($siswa_q)) : ?>
                        <option value="<?= $s['id_siswa']; ?>">
                            <?= htmlspecialchars($s['nis'] . " - " . $s['nama']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bulan">Bulan</label>
                <select id="bulan" name="bulan" class="form-control" required>
                    <option value="">--Pilih Bulan--</option>
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input
                    type="number"
                    id="tahun"
                    name="tahun"
                    class="form-control"
                    value="<?= date('Y'); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="tanggal_bayar">Tanggal Bayar</label>
                <input
                    type="date"
                    id="tanggal_bayar"
                    name="tanggal_bayar"
                    class="form-control"
                    value="<?= date('Y-m-d'); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="jumlah_bayar">Jumlah Bayar</label>
                <input
                    type="number"
                    id="jumlah_bayar"
                    name="jumlah_bayar"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" name="simpan" class="btn btn-primary">
                Simpan
            </button>
            <a href="pembayaran_tampil.php" class="btn btn-outline">
                Batal
            </a>
        </form>
    </div>
</div>

</body>
</html>
