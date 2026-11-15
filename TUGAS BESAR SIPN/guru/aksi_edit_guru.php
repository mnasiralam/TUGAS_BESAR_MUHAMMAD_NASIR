<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_guru       = mysqli_real_escape_string($koneksi, $_POST['id'] ?? '');
    $id_user       = mysqli_real_escape_string($koneksi, $_POST['user_id'] ?? '');
    $nip_baru      = mysqli_real_escape_string($koneksi, trim($_POST['nip'] ?? ''));
    $nama          = mysqli_real_escape_string($koneksi, trim($_POST['nama'] ?? ''));
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? '');
    $username_baru = mysqli_real_escape_string($koneksi, trim($_POST['username'] ?? ''));
    $password      = $_POST['password'] ?? '';

    if (empty($id_guru)) {
        echo "<script>alert('ID Guru tidak valid!'); window.history.back();</script>";
        exit;
    }

    // 1. Ambil data lama guru untuk perbandingan NIP jika diperlukan
    $q_lama = mysqli_query($koneksi, "SELECT nip FROM guru WHERE id = '$id_guru'");
    $d_lama = mysqli_fetch_assoc($q_lama);
    $nip_lama = $d_lama['nip'] ?? '';

    // 2. Cek duplikasi NIP jika NIP diubah
    if ($nip_baru !== $nip_lama) {
        $cek_nip = mysqli_query($koneksi, "SELECT * FROM guru WHERE nip = '$nip_baru' AND id != '$id_guru'");
        if (mysqli_num_rows($cek_nip) > 0) {
            echo "<script>alert('Gagal: NIP sudah terdaftar pada guru lain!'); window.history.back();</script>";
            exit;
        }
    }

    // 3. Cek duplikasi Username di tabel users (kecuali milik user ini sendiri)
    if (!empty($id_user)) {
        $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username_baru' AND id != '$id_user'");
        if (mysqli_num_rows($cek_user) > 0) {
            echo "<script>alert('Gagal: Username sudah digunakan oleh akun lain!'); window.history.back();</script>";
            exit;
        }
    }

    // 4. Update data pada tabel guru
    $update_guru = mysqli_query($koneksi, "UPDATE guru SET nip = '$nip_baru', nama = '$nama', jenis_kelamin = '$jenis_kelamin' WHERE id = '$id_guru'");

    // 5. Update data pada tabel users (username dan opsional password)
    if (!empty($id_user)) {
        if (!empty($password)) {
            // Jika password diisi, update username dan password baru
            $sql_user = "UPDATE users SET username = '$username_baru', password = '$password' WHERE id = '$id_user'";
        } else {
            // Jika password dikosongkan, hanya update username saja
            $sql_user = "UPDATE users SET username = '$username_baru' WHERE id = '$id_user'";
        }
        mysqli_query($koneksi, $sql_user);
    }

    if ($update_guru) {
        echo "<script>alert('Data guru dan akun berhasil diperbarui!'); window.location.href='tabel_guru.php';</script>";
    } else {
        $err = mysqli_error($koneksi);
        echo "<script>alert('Gagal memperbarui data guru: $err'); window.history.back();</script>";
    }
} else {
    header("Location: tabel_guru.php");
    exit;
}
?>