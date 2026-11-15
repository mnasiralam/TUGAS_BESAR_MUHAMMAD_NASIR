<?php
session_start();
require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis           = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama          = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas         = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $username      = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah digunakan
    $cek_username = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location.href='register.php';</script>";
        exit;
    }

    // 1. Masukkan data ke tabel users terlebih dahulu
    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'siswa')";

    if (mysqli_query($koneksi, $sql_user)) {
        // Ambil ID user yang baru saja digenerate
        $user_id = mysqli_insert_id($koneksi);

        // 2. Masukkan data ke tabel siswa dengan menyertakan user_id
        $sql_siswa = "INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES ('$nis', '$nama', '$kelas', '$jenis_kelamin', '$user_id')";

        if (mysqli_query($koneksi, $sql_siswa)) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href='login.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan biodata siswa!'); window.location.href='register.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Gagal membuat akun user!'); window.location.href='register.php';</script>";
        exit;
    }
} else {
    header("Location: register.php");
    exit;
}
?>