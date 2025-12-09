<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

$nama   = isset($_GET['nama']) ? mysqli_real_escape_string($koneksi, $_GET['nama']) : '';
$kelas  = isset($_GET['kelas']) ? mysqli_real_escape_string($koneksi, $_GET['kelas']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$where = [];

if ($nama != '') {
    $where[] = "s.nama LIKE '%$nama%'";
}
if ($kelas != '') {
    $where[] = "s.kelas LIKE '%$kelas%'";
}
// status: lunas / belum
$status_condition = "";
if ($status == "lunas") {
    $status_condition = " HAVING total_bayar >= (s.spp_per_bulan * 12)";
} elseif ($status == "belum") {
    $status_condition = " HAVING total_bayar < (s.spp_per_bulan * 12)";
}

$sql = "SELECT s.id_siswa, s.nis, s.nama, s.kelas, s.jurusan, s.spp_per_bulan,
        COALESCE(SUM(p.jumlah_bayar),0) AS total_bayar
        FROM siswa s
        LEFT JOIN pembayaran p ON s.id_siswa = p.id_siswa";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " GROUP BY s.id_siswa";

$sql_laporan = $sql . $status_condition;

$result = mysqli_query($koneksi, $sql_laporan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan SPP - SPP</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    <div class="navbar-brand">Pembayaran SPP</div>
    <div class="navbar-menu">
        <a href="index.php">Dashboard</a>
        <a href="siswa_tampil.php">Data Siswa</a>
        <a href="pembayaran_tampil.php">Data Pembayaran</a>
        <a href="laporan.php" class="active">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="page-wrapper">

    <div class="table-wrapper">
        <span class="pill-label">Laporan</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 6px;">
            Laporan Pembayaran SPP
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 10px;">
            Gunakan filter di bawah untuk melihat laporan berdasarkan nama, kelas, dan status pembayaran.
        </p>

        <!-- FORM FILTER -->
        <form method="get" class="filter-form">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control"
                    value="<?= htmlspecialchars($nama); ?>"
                    placeholder="Nama siswa"
                >
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    class="form-control"
                    value="<?= htmlspecialchars($kelas); ?>"
                    placeholder="Misal: X IPA 1"
                >
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">-- Semua --</option>
                    <option value="lunas" <?= $status == "lunas" ? "selected" : ""; ?>>Lunas</option>
                    <option value="belum" <?= $status == "belum" ? "selected" : ""; ?>>Belum Lunas</option>
                </select>
            </div>

            <div class="form-group filter-actions">
                <button type="submit" class="btn btn-primary">
                    Cari
                </button>
                <a href="laporan.php" class="btn btn-outline">
                    Reset
                </a>
            </div>
        </form>

        <!-- TABEL LAPORAN -->
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
                    $harus_bayar = $row['spp_per_bulan'] * 12; // misal 12 bulan
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
