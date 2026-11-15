<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}
require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kelas   = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');
    $id_guru = mysqli_real_escape_string($koneksi, $_POST['id_guru'] ?? '');

    if (empty($kelas) || empty($id_guru)) {
        echo "<script>alert('Kelas dan Guru wajib dipilih!'); window.location.href='form_tambah_mengajar.php';</script>";
        exit;
    }

    // 1. Ambil mapel_id berdasarkan guru yang dipilih
    $q_mapel = mysqli_query($koneksi, "SELECT id FROM mapel WHERE guru_id = '$id_guru' LIMIT 1");
    $d_mapel = mysqli_fetch_assoc($q_mapel);

    if (!$d_mapel) {
        echo "<script>alert('Gagal: Guru yang dipilih belum memiliki Mata Pelajaran di data Mapel!'); window.location.href='form_tambah_mengajar.php';</script>";
        exit;
    }
    $mapel_id = $d_mapel['id'];

    // 2. Ambil semua siswa berdasarkan kelas yang dipilih
    $q_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$kelas'");
    if (mysqli_num_rows($q_siswa) == 0) {
        echo "<script>alert('Gagal: Tidak ada data siswa yang ditemukan pada kelas $kelas!'); window.location.href='form_tambah_mengajar.php';</script>";
        exit;
    }

    $sukses = true;
    $jumlah_masuk = 0;

    // 3. Looping memasukkan data per siswa sesuai struktur asli tabel mengajar
    while ($d_siswa = mysqli_fetch_assoc($q_siswa)) {
        $siswa_id = $d_siswa['id'];

        // Cek apakah data relasi mapel dan siswa ini sudah ada sebelumnya
        $cek_exist = mysqli_query($koneksi, "SELECT * FROM mengajar WHERE mapel_id = '$mapel_id' AND siswa_id = '$siswa_id'");
        if (mysqli_num_rows($cek_exist) == 0) {
            $query = "INSERT INTO mengajar (mapel_id, siswa_id) VALUES ('$mapel_id', '$siswa_id')";
            if (mysqli_query($koneksi, $query)) {
                $jumlah_masuk++;
            } else {
                $sukses = false;
            }
        }
    }

    if ($sukses) {
        echo "<script>alert('Data mengajar berhasil ditambahkan untuk kelas $kelas!'); window.location.href='tabel_mengajar.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data mengajar!'); window.location.href='form_tambah_mengajar.php';</script>";
    }
} else {
    header("Location: tabel_mengajar.php");
    exit;
}
?>