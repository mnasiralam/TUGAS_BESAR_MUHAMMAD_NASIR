<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: access/login.php");
    exit;
}

require_once("db/koneksi.php");

$role     = $_SESSION['role'];
$username = $_SESSION['username'];
$user_id  = $_SESSION['user_id'];

// Ambil statistik ringkas berdasarkan role
$total_siswa = 0;
$total_guru  = 0;
$total_mapel = 0;
$total_kelas = 0;

if ($role === 'admin') {
    $q_s = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
    $total_siswa = mysqli_fetch_assoc($q_s)['total'] ?? 0;

    $q_g = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM guru");
    $total_guru = mysqli_fetch_assoc($q_g)['total'] ?? 0;

    $q_m = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM mapel");
    $total_mapel = mysqli_fetch_assoc($q_m)['total'] ?? 0;

    $q_k = mysqli_query($koneksi, "SELECT COUNT(DISTINCT kelas) AS total FROM siswa WHERE kelas != ''");
    $total_kelas = mysqli_fetch_assoc($q_k)['total'] ?? 0;
} elseif ($role === 'guru') {
    $q_guru = mysqli_query($koneksi, "SELECT id, nama FROM guru WHERE user_id = '$user_id' OR nip = '$username' LIMIT 1");
    $d_guru = mysqli_fetch_assoc($q_guru);
    $guru_id = $d_guru['id'] ?? 0;

    $q_k = mysqli_query($koneksi, "SELECT COUNT(DISTINCT s.kelas) AS total FROM mengajar m JOIN siswa s ON m.siswa_id = s.id JOIN mapel mp ON m.mapel_id = mp.id WHERE mp.guru_id = '$guru_id'");
    $total_kelas = mysqli_fetch_assoc($q_k)['total'] ?? 0;

    $q_m = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM mapel WHERE guru_id = '$guru_id'");
    $total_mapel = mysqli_fetch_assoc($q_m)['total'] ?? 0;
}

$base       = "";
$title_page = "Dashboard - SIPN";

require_once("header.php");
require_once("navbar.php");
?>

<div class="container my-4">
  <!-- Banner Sambutan -->
  <div class="card shadow-sm border-0 rounded-4 bg-primary text-white p-4 p-md-5 mb-4 position-relative overflow-hidden">
    <div style="z-index: 2; position: relative;">
      <h1 class="fw-bold mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['nama'] ?? $username); ?>! 👋</h1>
      <p class="lead opacity-75 mb-0">Sistem Informasi Akademik (SIPN) siap membantu mengelola aktivitas akademik dengan lebih mudah dan efisien.</p>
    </div>
    <div class="position-absolute end-0 bottom-0 translate-middle-end opacity-10 d-none d-md-block" style="font-size: 8rem; z-index: 1;">
      <i class="bi bi-mortarboard"></i>
    </div>
  </div>

  <!-- Statistik Utama (Khusus Admin & Guru) -->
  <?php if ($role === 'admin'): ?>
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-4">
            <i class="bi bi-people"></i>
          </div>
          <div>
            <span class="text-muted small d-block">Total Siswa</span>
            <h3 class="fw-bold mb-0 text-dark"><?= $total_siswa; ?></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 fs-4">
            <i class="bi bi-person-badge"></i>
          </div>
          <div>
            <span class="text-muted small d-block">Total Guru</span>
            <h3 class="fw-bold mb-0 text-dark"><?= $total_guru; ?></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-4">
            <i class="bi bi-journal-bookmark"></i>
          </div>
          <div>
            <span class="text-muted small d-block">Mata Pelajaran</span>
            <h3 class="fw-bold mb-0 text-dark"><?= $total_mapel; ?></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-info bg-opacity-10 text-info p-3 rounded-4 fs-4">
            <i class="bi bi-building"></i>
          </div>
          <div>
            <span class="text-muted small d-block">Total Kelas</span>
            <h3 class="fw-bold mb-0 text-dark"><?= $total_kelas; ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php elseif ($role === 'guru'): ?>
  <div class="row g-4 mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-4">
            <i class="bi bi-journal-text"></i>
          </div>
          <div>
            <span class="text-muted small d-block">Mata Pelajaran Diampu</span>
            <h3 class="fw-bold mb-0 text-dark"><?= $total_mapel; ?> Mapel</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 fs-4">
            <i class="bi bi-building"></i>
          </div>
          <div>
            <span class="text-muted small d-block">Kelas Yang Diajar</span>
            <h3 class="fw-bold mb-0 text-dark"><?= $total_kelas; ?> Kelas</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Panel Informasi Cepat -->
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
      <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Informasi Sistem</h5>
      <p class="text-muted mb-2">Anda masuk sebagai <strong><?= strtoupper($role); ?></strong>. Gunakan menu navigasi di atas untuk mengakses modul yang tersedia sesuai dengan hak akses Anda.</p>
      <div class="d-flex gap-2 mt-3">
        <?php if ($role === 'guru'): ?>
          <a href="nilai/daftar_kelas_guru.php" class="btn btn-primary btn-sm rounded-3 px-3">Kelola Nilai Siswa</a>
        <?php elseif ($role === 'siswa'): ?>
          <a href="nilai/lihat_nilai_siswa.php" class="btn btn-primary btn-sm rounded-3 px-3">Lihat Nilai Saya</a>
        <?php else: ?>
          <a href="user/tabel_user.php" class="btn btn-primary btn-sm rounded-3 px-3">Kelola Data User</a>
        <?php endif; ?>
        <a href="profile/index.php" class="btn btn-outline-secondary btn-sm rounded-3 px-3">Pengaturan Profil</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>