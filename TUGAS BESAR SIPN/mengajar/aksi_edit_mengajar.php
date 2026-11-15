<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}
require_once("../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_mapel_id = $_POST['old_mapel_id'] ?? '';
    $old_kelas    = $_POST['old_kelas'] ?? '';
    
    $new_kelas    = mysqli_real_escape_string($koneksi, $_POST['kelas'] ?? '');
    $new_id_guru  = mysqli_real_escape_string($koneksi, $_POST['id_guru'] ?? '');

    if (empty($new_kelas) || empty($new_id_guru) || empty($old_mapel_id) || empty($old_kelas)) {
        echo "<script>alert('Data tidak lengkap!'); window.location.href='tabel_mengajar.php';</script>";
        exit;
    }

    // 1. Ambil mapel_id baru berdasarkan guru yang dipilih
    $q_mapel = mysqli_query($koneksi, "SELECT id FROM mapel WHERE guru_id = '$new_id_guru' LIMIT 1");
    $d_mapel = mysqli_fetch_assoc($q_mapel);

    if (!$d_mapel) {
        echo "<script>alert('Gagal: Guru yang dipilih belum memiliki Mata Pelajaran!'); window.location.href='tabel_mengajar.php';</script>";
        exit;
    }
    $new_mapel_id = $d_mapel['id'];

    // 2. Hapus data mengajar yang lama
    $q_siswa_lama = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$old_kelas'");
    while ($d_sl = mysqli_fetch_assoc($q_siswa_lama)) {
        $siswa_lama_id = $d_sl['id'];
        mysqli_query($koneksi, "DELETE FROM mengajar WHERE mapel_id = '$old_mapel_id' AND siswa_id = '$siswa_lama_id'");
    }

    // 3. Masukkan data mengajar yang baru ke setiap siswa di kelas baru
    $q_siswa_baru = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$new_kelas'");
    if (mysqli_num_rows($q_siswa_baru) == 0) {
        echo "<script>alert('Gagal: Tidak ada siswa yang ditemukan pada kelas $new_kelas!'); window.location.href='tabel_mengajar.php';</script>";
        exit;
    }

    $sukses = true;
    while ($d_sb = mysqli_fetch_assoc($q_siswa_baru)) {
        $siswa_baru_id = $d_sb['id'];

        $cek_exist = mysqli_query($koneksi, "SELECT * FROM mengajar WHERE mapel_id = '$new_mapel_id' AND siswa_id = '$siswa_baru_id'");
        if (mysqli_num_rows($cek_exist) == 0) {
            $query = "INSERT INTO mengajar (mapel_id, siswa_id) VALUES ('$new_mapel_id', '$siswa_baru_id')";
            if (!mysqli_query($koneksi, $query)) {
                $sukses = false;
            }
        }
    }

    if ($sukses) {
        echo "<script>alert('Data mengajar berhasil diperbarui!'); window.location.href='tabel_mengajar.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui data mengajar!'); window.location.href='tabel_mengajar.php';</script>";
    }
} else {
    header("Location: tabel_mengajar.php");
    exit;
}
?>