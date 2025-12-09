<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php"); exit;
}
require "../config/koneksi.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

mysqli_query($koneksi, "DELETE FROM siswa WHERE id_siswa=$id");

header("Location: siswa_tampil.php");
exit;
