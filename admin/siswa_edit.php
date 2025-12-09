<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$q = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa=$id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data siswa tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $nis    = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas  = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan= mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $spp    = (int) $_POST['spp_per_bulan'];

    mysqli_query($koneksi, "UPDATE siswa SET 
        nis='$nis',
        nama='$nama',
        kelas='$kelas',
        jurusan='$jurusan',
        spp_per_bulan='$spp'
        WHERE id_siswa=$id");

    header("Location: siswa_tampil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa - SPP</title>
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
        <span class="pill-label">Edit Data</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 8px;">
            Edit Siswa
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 12px;">
            Perbarui data siswa lalu simpan untuk menyimpan perubahan.
        </p>

        <form method="post">
            <div class="form-group">
                <label for="nis">NIS</label>
                <input
                    type="text"
                    id="nis"
                    name="nis"
                    class="form-control"
                    value="<?= htmlspecialchars($data['nis']); ?>"
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
                    value="<?= htmlspecialchars($data['nama']); ?>"
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
                    value="<?= htmlspecialchars($data['kelas']); ?>"
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
                    value="<?= htmlspecialchars($data['jurusan']); ?>"
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
                    value="<?= htmlspecialchars($data['spp_per_bulan']); ?>"
                    required
                >
            </div>

            <button type="submit" name="update" class="btn btn-primary">
                Update
            </button>
            <a href="siswa_tampil.php" class="btn btn-outline">
                Batal
            </a>
        </form>
    </div>
</div>

</body>
</html>

