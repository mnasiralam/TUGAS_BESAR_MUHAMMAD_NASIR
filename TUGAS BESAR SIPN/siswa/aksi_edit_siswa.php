<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id            = mysqli_real_escape_string($koneksi, $_POST['id'] ?? '');
    $user_id       = mysqli_real_escape_string($koneksi, $_POST['user_id'] ?? '');
    $nis           = mysqli_real_escape_string($koneksi, $_POST['nis'] ?? '');
    $nama          = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
    $kelas         = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? '');
    $username      = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
    $password      = $_POST['password'] ?? '';

    if (empty($id)) {
        echo "<script>alert('ID Siswa tidak valid!'); window.location.href='tabel_siswa.php';</script>";
        exit;
    }

    // 1. Update data pada tabel siswa
    $sql_siswa = "UPDATE siswa SET nis='$nis', nama='$nama', kelas='$kelas', jenis_kelamin='$jenis_kelamin' WHERE id='$id'";
    $update_siswa = mysqli_query($koneksi, $sql_siswa);

    // 2. Update data pada tabel users (username dan opsional password)
    if (!empty($user_id)) {
        if (!empty($password)) {
            // Jika password diisi, update username dan password baru
            // (Sesuaikan jika sistem menggunakan enkripsi password_hash atau md5, di sini menggunakan password_hash standar)
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql_user = "UPDATE users SET username='$username', password='$password_hashed' WHERE id='$user_id'";
        } else {
            // Jika password dikosongkan, hanya update username saja
            $sql_user = "UPDATE users SET username='$username' WHERE id='$user_id'";
        }
        mysqli_query($koneksi, $sql_user);
    }

    if ($update_siswa) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location.href='tabel_siswa.php';</script>";
    } else {
        $error = mysqli_error($koneksi);
        echo "<script>alert('Gagal memperbarui data siswa: $error'); window.location.href='tabel_siswa.php';</script>";
    }
} else {
    header("Location: tabel_siswa.php");
    exit;
}
?>