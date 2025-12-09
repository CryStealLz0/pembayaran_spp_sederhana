<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

// optional: simple search by nama
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';

if ($keyword != '') {
    $q = "SELECT * FROM siswa 
          WHERE nama LIKE '%$keyword%' OR nis LIKE '%$keyword%' 
          ORDER BY nama ASC";
} else {
    $q = "SELECT * FROM siswa ORDER BY nama ASC";
}
$result = mysqli_query($koneksi, $q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - SPP</title>
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

    <div class="table-wrapper">
        <span class="pill-label">Data Master</span>

        <h1 class="page-title" style="font-size: 20px; margin-bottom: 6px;">
            Data Siswa
        </h1>

        <p class="dashboard-subtitle" style="margin-bottom: 10px;">
            Kelola data siswa, termasuk informasi kelas, jurusan, dan SPP per bulan.
        </p>

        <div style="margin-bottom: 10px;">
            <a href="siswa_tambah.php" class="btn btn-primary">
                + Tambah Siswa
            </a>
        </div>

        <!-- Form Pencarian -->
        <form method="get" class="search-bar">
            <input
                type="text"
                name="keyword"
                placeholder="Cari nama / NIS..."
                value="<?= htmlspecialchars($keyword); ?>"
                class="form-control search-input"
            >
            <button type="submit" class="btn btn-outline search-btn">Cari</button>
            <a href="siswa_tampil.php" class="btn btn-outline search-btn">Reset</a>
        </form>

        <!-- Tabel Data -->
        <table>
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>SPP/Bulan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['nis']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['kelas']); ?></td>
                    <td><?= htmlspecialchars($row['jurusan']); ?></td>
                    <td>Rp <?= number_format($row['spp_per_bulan'], 0, ',', '.'); ?></td>
                    <td>
                        <a class="btn btn-outline" href="siswa_edit.php?id=<?= $row['id_siswa']; ?>">
                            Edit
                        </a>
                        <a
                            class="btn btn-danger"
                            href="siswa_hapus.php?id=<?= $row['id_siswa']; ?>"
                            onclick="return confirm('Yakin hapus data siswa ini?')"
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

