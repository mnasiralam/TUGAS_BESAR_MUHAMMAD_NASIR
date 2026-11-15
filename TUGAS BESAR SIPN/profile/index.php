<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'];

// Ambil data dasar user
$q_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$d_user = mysqli_fetch_assoc($q_user);

$nama_tampil = $d_user['username'];
$info_tambahan = [];

if ($role === 'guru') {
    $q_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id = '$user_id' OR nip = '{$d_user['username']}' LIMIT 1");
    if ($d_guru = mysqli_fetch_assoc($q_guru)) {
        $nama_tampil = $d_guru['nama'];
        $info_tambahan = $d_guru;
    }
} elseif ($role === 'siswa') {
    $q_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE user_id = '$user_id' LIMIT 1");
    if ($d_siswa = mysqli_fetch_assoc($q_siswa)) {
        $nama_tampil = $d_siswa['nama'];
        $info_tambahan = $d_siswa;
    }
}

$base       = "../"; 
$title_page = "Profil Saya - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
      
      <div class="text-center mb-4">
        <i class="bi bi-person-circle display-4 text-primary mb-2"></i>
        <h3 class="fw-bold mb-1">Profil & Pengaturan Akun</h3>
        <p class="text-muted small">Kelola informasi akun dan ubah kata sandi Anda di sini.</p>
      </div>

      <?php if (isset($_GET['status'])): ?>
          <?php if ($_GET['status'] == 'sukses'): ?>
              <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                  <i class="bi bi-check-circle-fill me-2"></i> Profil atau kata sandi berhasil diperbarui!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php elseif ($_GET['status'] == 'gagal_password'): ?>
              <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                  <i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal memperbarui! Konfirmasi kata sandi baru tidak sesuai.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>
      <?php endif; ?>

      <!-- Informasi Profil -->
      <div class="mb-4 p-3 bg-light rounded-3 border-0">
          <h5 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill"></i> Informasi Pengguna
          </h5>
          <table class="table table-borderless mb-0">
              <tr>
                  <td width="35%" class="fw-semibold text-muted">Username / ID</td>
                  <td width="65%">: <?= htmlspecialchars($d_user['username']); ?></td>
              </tr>
              <tr>
                  <td class="fw-semibold text-muted">Nama Lengkap</td>
                  <td>: <?= htmlspecialchars($nama_tampil); ?></td>
              </tr>
              <tr>
                  <td class="fw-semibold text-muted">Hak Akses (Role)</td>
                  <td>: <span class="badge bg-secondary text-uppercase"><?= htmlspecialchars($role); ?></span></td>
              </tr>
              <?php if ($role === 'siswa' && isset($info_tambahan['kelas'])): ?>
              <tr>
                  <td class="fw-semibold text-muted">Kelas</td>
                  <td>: <?= htmlspecialchars($info_tambahan['kelas']); ?></td>
              </tr>
              <tr>
                  <td class="fw-semibold text-muted">NIS</td>
                  <td>: <?= htmlspecialchars($info_tambahan['nis'] ?? '-'); ?></td>
              </tr>
              <?php endif; ?>
              <?php if ($role === 'guru' && isset($info_tambahan['nip'])): ?>
              <tr>
                  <td class="fw-semibold text-muted">NIP</td>
                  <td>: <?= htmlspecialchars($info_tambahan['nip'] ?? '-'); ?></td>
              </tr>
              <?php endif; ?>
          </table>
      </div>

      <!-- Form Ubah Password -->
      <div class="p-3 bg-light rounded-3 border-0">
          <h5 class="fw-bold mb-3 text-primary d-flex align-items-center gap-2">
            <i class="bi bi-shield-lock-fill"></i> Ubah Kata Sandi
          </h5>
          <form action="aksi_update_profile.php" method="POST">
              <div class="mb-3">
                  <label class="form-label small fw-semibold">Kata Sandi Baru</label>
                  <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah sandi">
              </div>
              <div class="mb-3">
                  <label class="form-label small fw-semibold">Konfirmasi Kata Sandi Baru</label>
                  <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi kata sandi baru">
              </div>
              <div class="d-flex justify-content-end gap-2">
                  <a href="../index.php" class="btn btn-light rounded-3 px-4">Kembali</a>
                  <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Perubahan</button>
              </div>
          </form>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>