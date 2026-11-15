<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = mysqli_real_escape_string($koneksi, $_POST['id']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $role     = mysqli_real_escape_string($koneksi, $_POST['role']);

    // 1. Update tabel users (username, role, dan password jika diisi)
    if (!empty($password)) {
        // Jika password diisi, perbarui password beserta username & role
        $query_user = "UPDATE users SET username = '$username', password = '$password', role = '$role' WHERE id = '$id'";
    } else {
        // Jika password kosong, jangan ubah password yang lama
        $query_user = "UPDATE users SET username = '$username', role = '$role' WHERE id = '$id'";
    }
    mysqli_query($koneksi, $query_user);

    // 2. Perbarui data profil terkait berdasarkan role
    if ($role === 'guru') {
        $guru_id       = mysqli_real_escape_string($koneksi, $_POST['guru_id'] ?? 0);
        $nip           = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
        $nama          = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
        $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? '');

        if (!empty($guru_id)) {
            mysqli_query($koneksi, "UPDATE guru SET nip = '$nip', nama = '$nama', jenis_kelamin = '$jenis_kelamin' WHERE id = '$guru_id'");
        }
    } elseif ($role === 'siswa') {
        $siswa_id      = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? 0);
        $nis           = mysqli_real_escape_string($koneksi, $_POST['nis'] ?? '');
        $nama          = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
        $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? '');
        $kelas         = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');

        if (!empty($siswa_id)) {
            mysqli_query($koneksi, "UPDATE siswa SET nis = '$nis', nama = '$nama', jenis_kelamin = '$jenis_kelamin', kelas = '$kelas' WHERE id = '$siswa_id'");
        }
    }

    // Arahkan kembali ke tabel user setelah berhasil
    header("Location: tabel_user.php?pesan=sukses");
    exit;
} else {
    header("Location: tabel_user.php");
    exit;
}