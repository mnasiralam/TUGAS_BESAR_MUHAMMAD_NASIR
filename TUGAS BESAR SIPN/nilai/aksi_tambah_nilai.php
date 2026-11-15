<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siswa_id          = mysqli_real_escape_string($koneksi, $_POST['siswa_id'] ?? '');
    $mapel_id          = mysqli_real_escape_string($koneksi, $_POST['mapel_id'] ?? '');
    $kelas             = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');
    $nilai_kkm         = mysqli_real_escape_string($koneksi, $_POST['nilai_kkm'] ?? '');
    $nilai_pengetahuan = mysqli_real_escape_string($koneksi, $_POST['nilai_pengetahuan'] ?? '');
    $nilai_keterampilan= mysqli_real_escape_string($koneksi, $_POST['nilai_keterampilan'] ?? '');
    $Keterangan        = mysqli_real_escape_string($koneksi, $_POST['Keterangan'] ?? '');

    $sql = "INSERT INTO nilai_rapor (siswa_id, mapel_id, nilai_kkm, nilai_pengetahuan, nilai_keterampilan, Keterangan) 
            VALUES ('$siswa_id', '$mapel_id', '$nilai_kkm', '$nilai_pengetahuan', '$nilai_keterampilan', '$Keterangan')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Nilai berhasil disimpan!'); window.location.href='nilai_siswa_guru.php?kelas=" . urlencode($kelas) . "&mapel_id=" . $mapel_id . "';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan nilai!'); window.history.back();</script>";
    }
} else {
    header("Location: daftar_kelas_guru.php");
    exit;
}
?>