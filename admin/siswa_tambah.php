<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $nis    = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas  = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan= mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $spp    = (int) $_POST['spp_per_bulan'];

    $q = "INSERT INTO siswa (nis, nama, kelas, jurusan, spp_per_bulan)
          VALUES ('$nis', '$nama', '$kelas', '$jurusan', '$spp')";
    mysqli_query($koneksi, $q);

    header("Location: siswa_tampil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa - SPP</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    <div class="navbar-brand">Pembayaran SPP</div>
    <div class="navbar-menu">
        <a href="index.php">Dashboard</a>
        <a href="siswa_tampil.php" class="active">Data Siswa</a>
        <a href="pembayaran_tampil.php">Data Pembayaran</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="page-wrapper">
    <div class="card card-form">
        <span class="pill-label">Input Data</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 8px;">
            Tambah Siswa
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 12px;">
            Isi form berikut untuk menambahkan siswa baru.
        </p>

        <form method="post">
            <div class="form-group">
                <label for="nis">NIS</label>
                <input
                    type="text"
                    id="nis"
                    name="nis"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label for="nama">Nama</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input
                    type="text"
                    id="jurusan"
                    name="jurusan"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label for="spp_per_bulan">SPP per Bulan</label>
                <input
                    type="number"
                    id="spp_per_bulan"
                    name="spp_per_bulan"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" name="simpan" class="btn btn-primary">
                Simpan
            </button>
            <a href="siswa_tampil.php" class="btn btn-outline">
                Batal
            </a>
        </form>
    </div>
</div>

</body>
</html>

