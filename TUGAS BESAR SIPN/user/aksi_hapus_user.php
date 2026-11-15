<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if (isset($_GET['id'])) {
    $id_user = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil data user terlebih dahulu untuk tahu username dan role-nya
    $query_get = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id_user'");
    if ($row_user = mysqli_fetch_assoc($query_get)) {
        $username = $row_user['username'];
        $role     = $row_user['role'];

        // Bersihkan username dari angka untuk pencocokan nama yang fleksibel
        $clean_username = trim(preg_replace('/[0-9]+/', '', $username));

        // 2. Hapus data relasi berdasarkan role
        if ($role == 'siswa') {
            $q_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE user_id = '$id_user' OR nis = '$username' OR LOWER(nama) LIKE '%$username%'" . (!empty($clean_username) ? " OR LOWER(nama) LIKE '%$clean_username%'" : ""));
            while ($d_siswa = mysqli_fetch_assoc($q_siswa)) {
                $siswa_id = $d_siswa['id'];
                mysqli_query($koneksi, "DELETE FROM mengajar WHERE siswa_id = '$siswa_id'");
            }
            mysqli_query($koneksi, "DELETE FROM siswa WHERE user_id = '$id_user' OR nis = '$username' OR LOWER(nama) LIKE '%$username%'" . (!empty($clean_username) ? " OR LOWER(nama) LIKE '%$clean_username%'" : ""));
        } 
        elseif ($role == 'guru') {
            // Hapus data dari tabel guru berdasarkan user_id, nip, atau pencocokan nama
            mysqli_query($koneksi, "DELETE FROM guru WHERE user_id = '$id_user' OR nip = '$username' OR LOWER(nama) LIKE '%$username%'" . (!empty($clean_username) ? " OR LOWER(nama) LIKE '%$clean_username%'" : ""));
        }

        // 3. Terakhir, hapus data dari tabel users
        $hapus_user = mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id_user'");

        if ($hapus_user) {
            echo "<script>alert('User dan data master guru/siswa terkait berhasil dihapus!'); window.location.href='tabel_user.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus user!'); window.location.href='tabel_user.php';</script>";
        }
    } else {
        echo "<script>alert('Data user tidak ditemukan!'); window.location.href='tabel_user.php';</script>";
    }
} else {
    header("Location: tabel_user.php");
    exit;
}
?>