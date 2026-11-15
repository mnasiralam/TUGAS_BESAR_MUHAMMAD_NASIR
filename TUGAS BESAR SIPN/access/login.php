<?php
session_start();
$base       = "../";
$title_page = "Login - SIPN";

require_once("../header.php");
?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="card shadow-sm border-0 rounded-4 p-4" style="width: 100%; max-width: 400px;">
    
    <div class="text-center mb-4">
      <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex mb-3">
        <i class="bi bi-mortarboard-fill fs-1"></i>
      </div>
      <h3 class="fw-bold mb-1">SIPN Login</h3>
      <p class="text-muted small mb-0">Sistem Informasi Akademik</p>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
      <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
        <?= htmlspecialchars($_GET['pesan']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="aksi_login.php" method="POST">
      <div class="mb-3">
        <label class="form-label fw-semibold small">Username</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-person text-muted"></i></span>
          <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Masukkan username" required>
        </div>
      </div>
      
      <div class="mb-4">
        <label class="form-label fw-semibold small">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-lock text-muted"></i></span>
          <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password" required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">
        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
      </button>
    </form>
    
    <div class="text-center mt-3">
      <small class="text-muted">Belum punya akun? <a href="register.php" class="text-primary text-decoration-none fw-semibold">Registrasi</a></small>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>