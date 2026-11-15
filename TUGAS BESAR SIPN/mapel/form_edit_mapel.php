<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$id = $_GET['id'] ?? 0;

// Ambil data mapel berdasarkan ID
$q_mapel = mysqli_query($koneksi, "SELECT * FROM mapel WHERE id = '$id'");
$d_mapel = mysqli_fetch_assoc($q_mapel);

if (!$d_mapel) {
    header("Location: tabel_mapel.php");
    exit;
}

// Ambil daftar guru untuk pilihan pengampu
$q_guru = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama ASC");

$base       = "../";
$title_page = "Edit Mata Pelajaran - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Edit Mata Pelajaran</h3>
          <p class="text-muted small mb-0">Perbarui informasi kode, nama mapel, dan guru pengampu.</p>
        </div>
        <a href="tabel_mapel.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_edit_mapel.php" method="POST">
        <input type="hidden" name="id" value="<?= $d_mapel['id']; ?>">
        
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-book text-primary me-2"></i>Informasi Mata Pelajaran
          </h5>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Kode Mata Pelajaran:</label>
            <input type="text" name="kode_mapel" value="<?= htmlspecialchars($d_mapel['kode_mapel'] ?? ''); ?>" class="form-control rounded-3" placeholder="Contoh: MTK-10" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Nama Mata Pelajaran:</label>
            <input type="text" name="nama_mapel" value="<?= htmlspecialchars($d_mapel['nama_mapel'] ?? ''); ?>" class="form-control rounded-3" placeholder="Contoh: Matematika" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Guru Pengampu:</label>
            <select name="guru_id" class="form-select rounded-3" required>
              <option value="" disabled>-- Pilih Guru Pengampu --</option>
              <?php while ($guru = mysqli_fetch_assoc($q_guru)): ?>
                <option value="<?= $guru['id']; ?>" <?= ($d_mapel['guru_id'] == $guru['id']) ? 'selected' : ''; ?>>
                  <?= htmlspecialchars($guru['nama']); ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="tabel_mapel.php" class="btn btn-light rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-primary rounded-3 px-4">Perbarui Data</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>