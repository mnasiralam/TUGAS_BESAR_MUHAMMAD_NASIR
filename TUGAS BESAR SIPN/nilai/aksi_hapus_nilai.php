<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

$nilai_id = $_GET['nilai_id'] ?? '';
$kelas    = $_GET['kelas'] ?? '';
$mapel_id = $_GET['mapel_id'] ?? '';

if (!empty($nilai_id)) {
    mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE id = '$nilai_id'");
    echo "<script>alert('Nilai berhasil dihapus!'); window.location.href='nilai_siswa_guru.php?kelas=" . urlencode($kelas) . "&mapel_id=" . $mapel_id . "';</script>";
} else {
    header("Location: daftar_kelas_guru.php");
    exit;
}
?>