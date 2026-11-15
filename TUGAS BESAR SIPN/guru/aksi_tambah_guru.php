<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip           = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama          = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $username      = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah NIP sudah terdaftar
    $cek_nip = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip = '$nip'");
    if (mysqli_num_rows($cek_nip) > 0) {
        echo "<script>alert('Gagal: NIP sudah terdaftar!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah username sudah digunakan
    $cek_user = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Gagal: Username sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // 1. Simpan ke tabel users terlebih dahulu dengan role 'guru'
    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'guru')";

    if (mysqli_query($koneksi, $sql_user)) {
        $user_id = mysqli_insert_id($koneksi);

        // 2. Simpan ke tabel guru dengan menyertakan user_id
        $sql_guru = "INSERT INTO guru (nip, nama, jenis_kelamin, user_id) VALUES ('$nip', '$nama', '$jenis_kelamin', '$user_id')";

        if (mysqli_query($koneksi, $sql_guru)) {
            echo "<script>alert('Data Guru dan Akun Login berhasil ditambahkan!'); window.location.href='tabel_guru.php';</script>";
            exit;
        } else {
            // Rollback user jika gagal insert guru
            mysqli_query($koneksi, "DELETE FROM users WHERE id = '$user_id'");
            echo "<script>alert('Gagal menyimpan biodata guru!'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Gagal membuat akun user guru!'); window.history.back();</script>";
        exit;
    }
} else {
    header("Location: tabel_guru.php");
    exit;
}
?>