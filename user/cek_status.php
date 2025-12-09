<?php
require "../config/koneksi.php";

$hasil = null;
$st = null;
$harus_bayar = 0;
$total_bayar = 0;

if (isset($_POST['cek'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);

    $sql = "SELECT s.id_siswa, s.nis, s.nama, s.kelas, s.jurusan, s.spp_per_bulan,
            COALESCE(SUM(p.jumlah_bayar),0) AS total_bayar
            FROM siswa s
            LEFT JOIN pembayaran p ON s.id_siswa = p.id_siswa
            WHERE s.nis='$nis'
            GROUP BY s.id_siswa";
    $result = mysqli_query($koneksi, $sql);
    $hasil = mysqli_fetch_assoc($result);

    if ($hasil) {
        $harus_bayar = $hasil['spp_per_bulan'] * 12;
        $total_bayar = $hasil['total_bayar'];
        $st = ($total_bayar >= $harus_bayar) ? "Lunas" : "Belum Lunas";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Status SPP - SPP</title>
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

            <span class="pill-label">Cek Status Pembayaran</span>

            <h1 class="page-title user-title">
                Cek Status SPP Berdasarkan NIS
            </h1>

            <p class="user-subtitle">
                Masukkan NIS untuk melihat status pembayaran SPP selama 1 tahun ajaran.
            </p>

            <!-- Link kembali ke home user -->
            <p class="user-footer-text" style="margin-bottom: 8px;">
                &larr; <a href="index.php">Kembali ke Home User</a>
            </p>

            <!-- FORM PENCARIAN -->
            <form method="post" class="status-form">
                <div class="form-group">
                    <label for="nis">Masukkan NIS</label>
                    <input
                        type="text"
                        id="nis"
                        name="nis"
                        class="form-control"
                        required
                        value="<?= isset($_POST['nis']) ? htmlspecialchars($_POST['nis']) : '' ?>"
                    >
                </div>
                <button type="submit" name="cek" class="btn btn-primary">
                    Cek Status
                </button>
            </form>

            <!-- HASIL PENCARIAN -->
            <?php if (isset($_POST['cek'])): ?>
                <?php if ($hasil): ?>
                    <div class="status-result">
                        <h3 class="status-result-title">Hasil Cek SPP</h3>

                        <div class="status-row">
                            <span class="status-label">NIS</span>
                            <span class="status-value"><?= htmlspecialchars($hasil['nis']); ?></span>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Nama</span>
                            <span class="status-value"><?= htmlspecialchars($hasil['nama']); ?></span>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Kelas / Jurusan</span>
                            <span class="status-value">
                                <?= htmlspecialchars($hasil['kelas']); ?> - <?= htmlspecialchars($hasil['jurusan']); ?>
                            </span>
                        </div>

                        <div class="status-divider"></div>

                        <div class="status-row">
                            <span class="status-label">SPP per Bulan</span>
                            <span class="status-value">
                                Rp <?= number_format($hasil['spp_per_bulan'], 0, ',', '.'); ?>
                            </span>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Total Harus Bayar (1 Tahun)</span>
                            <span class="status-value">
                                Rp <?= number_format($harus_bayar, 0, ',', '.'); ?>
                            </span>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Total Sudah Dibayar</span>
                            <span class="status-value">
                                Rp <?= number_format($total_bayar, 0, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="status-divider"></div>

                        <div class="status-row status-row-highlight">
                            <span class="status-label">Status</span>
                            <span class="status-value">
                                <?php if ($st === "Lunas"): ?>
                                    <span class="badge badge-success">Lunas</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum Lunas</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-error" style="margin-top: 16px;">
                        Data siswa dengan NIS tersebut tidak ditemukan.
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>
