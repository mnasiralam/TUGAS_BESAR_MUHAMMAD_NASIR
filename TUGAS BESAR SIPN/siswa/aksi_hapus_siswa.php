<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if (isset($_GET['id'])) {
    $id_siswa = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil data siswa untuk mengetahui NIS, user_id, dan Nama-nya
    $query_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id = '$id_siswa'");
    if ($row_siswa = mysqli_fetch_assoc($query_siswa)) {
        $nis     = $row_siswa['nis'];
        $user_id = $row_siswa['user_id'];
        $nama    = $row_siswa['nama'];
        $nama_depan = strtolower(explode(' ', trim($nama))[0]);

        // 2. Hapus terlebih dahulu data terkait di tabel mengajar (Mencegah Error Foreign Key)
        mysqli_query($koneksi, "DELETE FROM mengajar WHERE siswa_id = '$id_siswa'");

        // 3. Hapus akun dari tabel users (berdasarkan user_id atau nis/username)
        if (!empty($user_id)) {
            mysqli_query($koneksi, "DELETE FROM users WHERE id = '$user_id'");
        } else {
            mysqli_query($koneksi, "DELETE FROM users WHERE username = '$nis' OR username LIKE '%$nama_depan%'");
        }

        // 4. Terakhir, hapus data dari tabel siswa
        $hapus_siswa = mysqli_query($koneksi, "DELETE FROM siswa WHERE id = '$id_siswa'");

        if ($hapus_siswa) {
            echo "<script>alert('Data Siswa dan akun login terkait berhasil dihapus!'); window.location.href='tabel_siswa.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data siswa!'); window.location.href='tabel_siswa.php';</script>";
        }
    } else {
        echo "<script>alert('Data siswa tidak ditemukan!'); window.location.href='tabel_siswa.php';</script>";
    }
} else {
    header("Location: tabel_siswa.php");
    exit;
}
?>