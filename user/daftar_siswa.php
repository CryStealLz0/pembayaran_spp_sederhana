<?php
require "../config/koneksi.php";

$sql = "SELECT s.id_siswa, s.nis, s.nama, s.kelas, s.jurusan, s.spp_per_bulan,
        COALESCE(SUM(p.jumlah_bayar),0) AS total_bayar
        FROM siswa s
        LEFT JOIN pembayaran p ON s.id_siswa = p.id_siswa
        GROUP BY s.id_siswa";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa - SPP</title>
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

        <div class="table-wrapper">
            <span class="pill-label">Daftar Siswa</span>

            <h1 class="page-title" style="font-size: 20px; margin-bottom: 4px;">
                Daftar Siswa &amp; Status Pembayaran
            </h1>

            <p class="user-subtitle" style="margin-bottom: 12px;">
                Berikut adalah daftar seluruh siswa beserta status pembayaran SPP untuk 1 tahun ajaran.
            </p>

            <p class="user-footer-text" style="margin-bottom: 10px;">
                &larr; <a href="index.php">Kembali ke Home User</a>
            </p>

            <table>
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>SPP/Bulan</th>
                        <th>Harus Bayar (1 Tahun)</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) : 
                        $harus_bayar = $row['spp_per_bulan'] * 12;
                        $total_bayar = $row['total_bayar'];
                        $lunas = ($total_bayar >= $harus_bayar);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nis']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kelas']); ?></td>
                        <td><?= htmlspecialchars($row['jurusan']); ?></td>
                        <td>Rp <?= number_format($row['spp_per_bulan'], 0, ',', '.'); ?></td>
                        <td>Rp <?= number_format($harus_bayar, 0, ',', '.'); ?></td>
                        <td>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($lunas): ?>
                                <span class="badge badge-success">Lunas</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Belum Lunas</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
