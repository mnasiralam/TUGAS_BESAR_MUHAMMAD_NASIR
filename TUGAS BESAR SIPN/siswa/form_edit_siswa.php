<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$id = $_GET['id'] ?? 0;

// Ambil data siswa dan relasi ke tabel users
$q_siswa = mysqli_query($koneksi, "
    SELECT s.*, u.username 
    FROM siswa s 
    LEFT JOIN users u ON s.user_id = u.id 
    WHERE s.id = '$id'
");
$d_siswa = mysqli_fetch_assoc($q_siswa);

if (!$d_siswa) {
    header("Location: tabel_siswa.php");
    exit;
}

$base       = "../";
$title_page = "Edit Siswa - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Edit Data Siswa</h3>
          <p class="text-muted small mb-0">Perbarui informasi data diri dan akun siswa.</p>
        </div>
        <a href="tabel_siswa.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_edit_siswa.php" method="POST">
        <input type="hidden" name="id" value="<?= $d_siswa['id']; ?>">
        <input type="hidden" name="user_id" value="<?= $d_siswa['user_id']; ?>">

        <!-- Section 1: Data Profil User -->
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-person-vcard text-primary me-2"></i>Data Profil User
          </h5>

          <div class="mb-3">
            <label class="form-label fw-semibold small">NIS:</label>
            <input type="text" name="nis" value="<?= htmlspecialchars($d_siswa['nis'] ?? ''); ?>" class="form-control rounded-3" placeholder="Nomor Induk Siswa" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Nama Lengkap:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($d_siswa['nama'] ?? ''); ?>" class="form-control rounded-3" placeholder="Nama Lengkap Siswa" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Kelas:</label>
            <input type="text" name="kelas" value="<?= htmlspecialchars($d_siswa['kelas'] ?? ''); ?>" class="form-control rounded-3" placeholder="Kelas Siswa" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small d-block">Jenis Kelamin:</label>
            <div class="form-check form-check-inline me-4">
              <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" <?= (($d_siswa['jenis_kelamin'] ?? '') === 'Laki-laki') ? 'checked' : ''; ?> required>
              <label class="form-check-input-label small text-dark" for="jk_l">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" <?= (($d_siswa['jenis_kelamin'] ?? '') === 'Perempuan') ? 'checked' : ''; ?> required>
              <label class="form-check-input-label small text-dark" for="jk_p">Perempuan</label>
            </div>
          </div>
        </div>

        <!-- Section 2: Data Kredensial Akun -->
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-shield-lock text-primary me-2"></i>Data Kredensial Akun
          </h5>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($d_siswa['username'] ?? ''); ?>" class="form-control rounded-3" placeholder="Username Akun" required>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold small">Password Baru <span class="text-muted fw-normal">(Kosongkan jika tidak ingin diubah)</span>:</label>
            <input type="password" name="password" class="form-control rounded-3" placeholder="Masukkan password baru jika ingin diganti">
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="tabel_siswa.php" class="btn btn-light rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-primary rounded-3 px-4">Perbarui Data</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>