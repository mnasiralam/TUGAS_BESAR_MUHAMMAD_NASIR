<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id             = $_SESSION['user_id'];
    $password_baru       = mysqli_real_escape_string($koneksi, $_POST['password_baru']);
    $konfirmasi_password = mysqli_real_escape_string($koneksi, $_POST['konfirmasi_password']);

    // Jika kolom password diisi
    if (!empty($password_baru)) {
        if ($password_baru === $konfirmasi_password) {
            $sql = "UPDATE users SET password = '$password_baru' WHERE id = '$user_id'";
            if (mysqli_query($koneksi, $sql)) {
                header("Location: index.php?status=sukses");
                exit;
            } else {
                header("Location: index.php?status=gagal_password");
                exit;
            }
        } else {
            header("Location: index.php?status=gagal_password");
            exit;
        }
    } else {
        // Jika kosong, langsung arahkan sukses kembali
        header("Location: index.php?status=sukses");
        exit;
    }
} else {
    header("Location: index.php");
}
?>