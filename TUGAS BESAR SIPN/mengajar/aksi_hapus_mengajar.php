<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}
require_once("../db/koneksi.php");

$mapel_id = $_GET['mapel_id'] ?? '';
$kelas    = $_GET['kelas'] ?? '';

if (!empty($mapel_id) && !empty($kelas)) {
    // Ambil semua siswa di kelas tersebut
    $q_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$kelas'");
    
    while ($d_siswa = mysqli_fetch_assoc($q_siswa)) {
        $siswa_id = $d_siswa['id'];
        // Hapus data mengajar per siswa yang terhubung dengan mapel ini
        mysqli_query($koneksi, "DELETE FROM mengajar WHERE mapel_id = '$mapel_id' AND siswa_id = '$siswa_id'");
    }

    echo "<script>alert('Data mengajar berhasil dihapus!'); window.location.href='tabel_mengajar.php';</script>";
} else {
    header("Location: tabel_mengajar.php");
    exit;
}
?>