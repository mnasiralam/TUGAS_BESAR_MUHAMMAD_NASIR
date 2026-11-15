<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if (isset($_GET['id'])) {
    $id_guru = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil data guru untuk mengetahui NIP atau Nama-nya
    $query_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE id = '$id_guru'");
    if ($row_guru = mysqli_fetch_assoc($query_guru)) {
        $nip  = $row_guru['nip'];
        $nama = $row_guru['nama'];
        $nama_depan = strtolower(explode(' ', trim($nama))[0]);

        // 2. Hapus data dari tabel users yang username-nya cocok dengan NIP atau mengandung nama guru
        mysqli_query($koneksi, "DELETE FROM users WHERE username = '$nip' OR username LIKE '%$nama_depan%'");

        // 3. Hapus data dari tabel guru
        $hapus_guru = mysqli_query($koneksi, "DELETE FROM guru WHERE id = '$id_guru'");

        if ($hapus_guru) {
            echo "<script>alert('Data Guru dan akun login terkait berhasil dihapus!'); window.location.href='tabel_guru.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data guru!'); window.location.href='tabel_guru.php';</script>";
        }
    } else {
        echo "<script>alert('Data guru tidak ditemukan!'); window.location.href='tabel_guru.php';</script>";
    }
} else {
    header("Location: tabel_guru.php");
    exit;
}
?>