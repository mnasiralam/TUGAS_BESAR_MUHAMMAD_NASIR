<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$base       = "../";
$title_page = "Tambah Siswa - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Tambah Data Siswa</h3>
          <p class="text-muted small mb-0">Masukkan informasi data diri dan akun siswa baru.</p>
        </div>
        <a href="tabel_siswa.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_tambah_siswa.php" method="POST">
        
        <!-- Section 1: Data Profil User -->
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-person-vcard text-primary me-2"></i>Data Profil User
          </h5>

          <div class="mb-3">
            <label class="form-label fw-semibold small">NIS:</label>
            <input type="text" name="nis" class="form-control rounded-3" placeholder="Nomor Induk Siswa | Contoh: 1234567890" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Nama Lengkap:</label>
            <input type="text" name="nama" class="form-control rounded-3" placeholder="Nama Lengkap Siswa | Contoh: Ujang Asep" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Kelas:</label>
            <input type="text" name="kelas" class="form-control rounded-3" placeholder="Kelas Siswa | Contoh: XI-RPL-1" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small d-block">Jenis Kelamin:</label>
            <div class="form-check form-check-inline me-4">
              <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki" required>
              <label class="form-check-input-label small text-dark" for="jk_l">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" required>
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
            <input type="text" name="username" class="form-control rounded-3" placeholder="Username Akun | Contoh: ujang123" required>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold small">Password Akun:</label>
            <input type="password" name="password" class="form-control rounded-3" placeholder="Password Akun | Contoh: password123" required>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="tabel_siswa.php" class="btn btn-light rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Data</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>