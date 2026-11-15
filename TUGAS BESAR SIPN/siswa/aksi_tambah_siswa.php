<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis           = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama          = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas         = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $username      = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah digunakan di tabel users
    $cek_username = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Gagal: Username sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // 1. Masukkan data ke tabel users terlebih dahulu
    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'siswa')";

    if (mysqli_query($koneksi, $sql_user)) {
        // Ambil ID user yang baru saja digenerate secara otomatis
        $user_id = mysqli_insert_id($koneksi);

        // 2. Masukkan data ke tabel siswa dengan menyertakan user_id
        $sql_siswa = "INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES ('$nis', '$nama', '$kelas', '$jenis_kelamin', '$user_id')";

        if (mysqli_query($koneksi, $sql_siswa)) {
            echo "<script>alert('Data siswa dan akun login berhasil ditambahkan!'); window.location.href='tabel_siswa.php';</script>";
            exit;
        } else {
            // Rollback jika gagal insert siswa (hapus user yang terlanjur dibuat)
            mysqli_query($koneksi, "DELETE FROM users WHERE id = '$user_id'");
            echo "<script>alert('Gagal menyimpan biodata siswa!'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Gagal membuat akun user!'); window.history.back();</script>";
        exit;
    }
} else {
    header("Location: tabel_siswa.php");
    exit;
}
?>