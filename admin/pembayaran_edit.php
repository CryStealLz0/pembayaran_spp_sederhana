<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$pm_q = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_pembayaran=$id");
$data = mysqli_fetch_assoc($pm_q);
if (!$data) {
    die("Data pembayaran tidak ditemukan.");
}

$siswa_q = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama ASC");

if (isset($_POST['update'])) {
    $id_siswa = (int) $_POST['id_siswa'];
    $bulan = mysqli_real_escape_string($koneksi, $_POST['bulan']);
    $tahun = (int) $_POST['tahun'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $jumlah_bayar = (int) $_POST['jumlah_bayar'];

    mysqli_query($koneksi, "UPDATE pembayaran SET
        id_siswa='$id_siswa',
        bulan='$bulan',
        tahun='$tahun',
        tanggal_bayar='$tanggal_bayar',
        jumlah_bayar='$jumlah_bayar'
        WHERE id_pembayaran=$id");

    header("Location: pembayaran_tampil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pembayaran - SPP</title>
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
        <span class="pill-label">Edit Pembayaran</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 8px;">
            Edit Pembayaran
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 12px;">
            Ubah data pembayaran kemudian simpan untuk memperbarui catatan.
        </p>

        <form method="post">
            <div class="form-group">
                <label for="id_siswa">Siswa</label>
                <select id="id_siswa" name="id_siswa" class="form-control" required>
                    <?php while($s = mysqli_fetch_assoc($siswa_q)) : ?>
                        <option
                            value="<?= $s['id_siswa']; ?>"
                            <?= $s['id_siswa'] == $data['id_siswa'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($s['nis'] . " - " . $s['nama']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bulan">Bulan</label>
                <select id="bulan" name="bulan" class="form-control" required>
                    <?php
                    $bulan_list = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                    foreach ($bulan_list as $b) {
                        $sel = ($b == $data['bulan']) ? 'selected' : '';
                        echo "<option $sel>$b</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input
                    type="number"
                    id="tahun"
                    name="tahun"
                    class="form-control"
                    value="<?= htmlspecialchars($data['tahun']); ?>"
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
                    value="<?= htmlspecialchars($data['tanggal_bayar']); ?>"
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
                    value="<?= htmlspecialchars($data['jumlah_bayar']); ?>"
                    required
                >
            </div>

            <button type="submit" name="update" class="btn btn-primary">
                Update
            </button>
            <a href="pembayaran_tampil.php" class="btn btn-outline">
                Batal
            </a>
        </form>
    </div>
</div>

</body>
</html>
