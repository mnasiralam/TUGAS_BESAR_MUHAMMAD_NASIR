<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$base       = "../";
$title_page = "Tambah User - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Tambah Data Pengguna</h3>
          <p class="text-muted small mb-0">Masukkan informasi akun dan kredensial admin baru.</p>
        </div>
        <a href="tabel_user.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_tambah_user.php" method="POST">
        
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-person-lock text-primary me-2"></i>Informasi Akun & Kredensial
          </h5>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Username:</label>
            <input type="text" name="username" class="form-control rounded-3" placeholder="Contoh: admin_utama" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Password:</label>
            <input type="password" name="password" class="form-control rounded-3" placeholder="Masukkan password akun" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Role / Hak Akses:</label>
            <input type="text" class="form-control rounded-3 bg-light text-dark fw-semibold" value="Admin" readonly>
            <input type="hidden" name="role" value="admin">
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="tabel_user.php" class="btn btn-light rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Data</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>