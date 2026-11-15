<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Hapus terlebih dahulu data terkait di tabel anak (mengajar dan nilai_rapor)
    mysqli_query($koneksi, "DELETE FROM mengajar WHERE mapel_id = '$id'");
    mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE mapel_id = '$id'");

    // 2. Setelah data anak bersih, hapus data utama di tabel mapel
    $query_hapus = mysqli_query($koneksi, "DELETE FROM mapel WHERE id = '$id'");

    if ($query_hapus) {
        echo "<script>alert('Mata pelajaran berhasil dihapus!'); window.location.href='tabel_mapel.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus mata pelajaran!'); window.location.href='tabel_mapel.php';</script>";
    }
} else {
    header("Location: tabel_mapel.php");
    exit;
}
?>