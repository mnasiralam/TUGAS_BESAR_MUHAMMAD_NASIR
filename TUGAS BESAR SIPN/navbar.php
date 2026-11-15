<?php
// navbar.php
$base         = isset($base) ? $base : '';
$role         = $_SESSION['role'] ?? '';
$username     = $_SESSION['username'] ?? '';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark rounded-4 shadow-sm mb-4 px-4 py-3" style="background-color: #4f46e5 !important;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2 text-white" href="<?= $base; ?>index.php">
      <i class="bi bi-mortarboard-fill"></i> SIPN
    </a>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
        <li class="nav-item">
          <a class="nav-link px-3 rounded-3 <?= ($current_page == 'index.php') ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= ($current_page == 'index.php') ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>index.php">
            <i class="bi bi-speedometer2 me-1"></i> Dashboard
          </a>
        </li>

        <?php if ($role === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'user') !== false) ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'user') !== false) ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>user/tabel_user.php">
              <i class="bi bi-people me-1"></i> User
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'siswa') !== false) ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'siswa') !== false) ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>siswa/tabel_siswa.php">
              <i class="bi bi-person-badge me-1"></i> Siswa
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'guru') !== false) ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'guru') !== false) ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>guru/tabel_guru.php">
              <i class="bi bi-person-video3 me-1"></i> Guru
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'mapel') !== false) ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'mapel') !== false) ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>mapel/tabel_mapel.php">
              <i class="bi bi-book me-1"></i> Mapel
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'mengajar') !== false) ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'mengajar') !== false) ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>mengajar/tabel_mengajar.php">
              <i class="bi bi-journal-check me-1"></i> Mengajar
            </a>
          </li>

        <?php elseif ($role === 'guru'): ?>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'nilai') !== false && basename($_SERVER['PHP_SELF']) !== 'lihat_nilai_siswa.php') ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'nilai') !== false && basename($_SERVER['PHP_SELF']) !== 'lihat_nilai_siswa.php') ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>nilai/daftar_kelas_guru.php">
              <i class="bi bi-journal-text me-1"></i> Nilai Siswa
            </a>
          </li>

        <?php elseif ($role === 'siswa'): ?>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-3 <?= (strpos($_SERVER['PHP_SELF'], 'nilai') !== false) ? 'active bg-white text-indigo fw-semibold shadow-sm' : 'text-white'; ?>" style="<?= (strpos($_SERVER['PHP_SELF'], 'nilai') !== false) ? 'color: #4f46e5 !important;' : ''; ?>" href="<?= $base; ?>nilai/lihat_nilai_siswa.php">
              <i class="bi bi-award me-1"></i> Nilai Saya
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold text-white d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5"></i> <span><?= htmlspecialchars($username); ?> <small class="opacity-75">(<?= ucfirst($role); ?>)</small></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-2">
            <li>
              <a class="dropdown-item py-2 fw-semibold text-secondary" href="<?= $base; ?>profile/index.php">
                <i class="bi bi-gear me-2"></i> Profil & Pengaturan
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item py-2 text-danger fw-semibold" href="<?= $base; ?>access/logout.php" onclick="return confirm('Yakin ingin keluar dari sistem?')">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>