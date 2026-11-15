<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = 'admin'; // Pastikan khusus admin

    // Cek duplikasi username
    $cek = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Gagal: Username sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Akun admin berhasil ditambahkan!'); window.location.href='tabel_user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan admin!'); window.history.back();</script>";
    }
} else {
    header("Location: tabel_user.php");
    exit;
}
?>