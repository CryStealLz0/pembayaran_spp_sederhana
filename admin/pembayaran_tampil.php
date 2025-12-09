<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

$q = "SELECT p.*, s.nis, s.nama 
      FROM pembayaran p
      JOIN siswa s ON p.id_siswa = s.id_siswa
      ORDER BY p.tanggal_bayar DESC";
$result = mysqli_query($koneksi, $q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pembayaran - SPP</title>
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

    <div class="table-wrapper">
        <span class="pill-label">Transaksi</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 6px;">
            Data Pembayaran
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 10px;">
            Riwayat pembayaran SPP yang sudah tercatat di sistem.
        </p>

        <div style="margin-bottom: 10px;">
            <a href="pembayaran_tambah.php" class="btn btn-primary">
                + Tambah Pembayaran
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['nis'] . " - " . $row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['bulan']); ?></td>
                    <td><?= htmlspecialchars($row['tahun']); ?></td>
                    <td><?= htmlspecialchars($row['tanggal_bayar']); ?></td>
                    <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.'); ?></td>
                    <td>
                        <a class="btn btn-outline" href="pembayaran_edit.php?id=<?= $row['id_pembayaran']; ?>">
                            Edit
                        </a>
                        <a
                            class="btn btn-danger"
                            href="pembayaran_hapus.php?id=<?= $row['id_pembayaran']; ?>"
                            onclick="return confirm('Yakin hapus data pembayaran ini?')"
                        >
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>

