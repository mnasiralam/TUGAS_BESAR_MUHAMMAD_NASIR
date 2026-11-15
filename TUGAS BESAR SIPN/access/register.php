<?php
session_start();
$base       = "../";
$title_page = "Registrasi - SIPN";

require_once("../header.php");
?>

<div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
  <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5" style="width: 100%; max-width: 600px;">
    
    <div class="text-center mb-4">
      <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex mb-3">
        <i class="bi bi-person-plus-fill fs-1"></i>
      </div>
      <h3 class="fw-bold mb-1">Registrasi Akun</h3>
      <p class="text-muted small mb-0">Isi data diri dan informasi akun Anda di bawah ini.</p>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
      <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
        <?= htmlspecialchars($_GET['pesan']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="aksi_register.php" method="POST">
      
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

      <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-semibold">
        <i class="bi bi-check-circle me-1"></i> Daftar Sekarang
      </button>
    </form>
    
    <div class="text-center mt-3">
      <small class="text-muted">Sudah punya akun? <a href="login.php" class="text-primary text-decoration-none fw-semibold">Masuk</a></small>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>