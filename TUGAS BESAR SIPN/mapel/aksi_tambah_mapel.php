<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mapel = mysqli_real_escape_string($koneksi, $_POST['kode_mapel'] ?? '');
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel'] ?? '');
    
    $guru_id = !empty($_POST['guru_id']) ? "'" . mysqli_real_escape_string($koneksi, $_POST['guru_id']) . "'" : "NULL";

    $sql = "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id) 
            VALUES ('$kode_mapel', '$nama_mapel', $guru_id)";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Mata pelajaran berhasil ditambahkan!'); window.location.href='tabel_mapel.php';</script>";
        exit();
    } else {
        $error = mysqli_error($koneksi);
        echo "<script>alert('Gagal menyimpan data: $error'); window.history.back();</script>";
        exit();
    }
} else {
    header("Location: tabel_mapel.php");
    exit();
}
?>