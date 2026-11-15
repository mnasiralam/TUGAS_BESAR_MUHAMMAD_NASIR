<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nilai_id          = mysqli_real_escape_string($koneksi, $_POST['nilai_id'] ?? '');
    $kelas             = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');
    $mapel_id          = mysqli_real_escape_string($koneksi, $_POST['mapel_id'] ?? '');
    $nilai_kkm         = mysqli_real_escape_string($koneksi, $_POST['nilai_kkm'] ?? '');
    $nilai_pengetahuan = mysqli_real_escape_string($koneksi, $_POST['nilai_pengetahuan'] ?? '');
    $nilai_keterampilan= mysqli_real_escape_string($koneksi, $_POST['nilai_keterampilan'] ?? '');
    $Keterangan        = mysqli_real_escape_string($koneksi, $_POST['Keterangan'] ?? '');

    $sql = "UPDATE nilai_rapor SET 
            nilai_kkm = '$nilai_kkm', 
            nilai_pengetahuan = '$nilai_pengetahuan', 
            nilai_keterampilan = '$nilai_keterampilan', 
            Keterangan = '$Keterangan' 
            WHERE id = '$nilai_id'";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Nilai berhasil diupdate!'); window.location.href='nilai_siswa_guru.php?kelas=" . urlencode($kelas) . "&mapel_id=" . $mapel_id . "';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate nilai!'); window.history.back();</script>";
    }
} else {
    header("Location: daftar_kelas_guru.php");
    exit;
}
?>