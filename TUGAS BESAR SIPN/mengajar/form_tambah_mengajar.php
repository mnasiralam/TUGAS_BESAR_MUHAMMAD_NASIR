<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}
require_once("../db/koneksi.php");

// Ambil data guru untuk pilihan dropdown[cite: 6]
$q_guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nama ASC");

// Ambil daftar kelas unik dari tabel siswa[cite: 6]
$q_kelas = mysqli_query($koneksi, "SELECT DISTINCT kelas FROM siswa WHERE kelas != '' ORDER BY kelas ASC");

$base       = "../";
$title_page = "Tambah Mengajar - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Form Tambah Mengajar</h3>
          <p class="text-muted small mb-0">Pilih guru dan kelas tujuan untuk penugasan mengajar.</p>
        </div>
        <a href="tabel_mengajar.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_tambah_mengajar.php" method="POST">
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-journal-plus text-primary me-2"></i>Detail Penugasan
          </h5>

          <div class="mb-3">
            <label for="id_guru" class="form-label fw-semibold small">Pilih Guru & Mata Pelajaran</label>
            <select name="id_guru" id="id_guru" class="form-select rounded-3" required>
                <option value="">-- Pilih Guru --</option>
                <?php while ($g = mysqli_fetch_assoc($q_guru)): ?>
                    <?>
                    <?php 
                        $id_g = $g['id'];
                        $q_m = mysqli_query($koneksi, "SELECT nama_mapel FROM mapel WHERE guru_id = '$id_g' LIMIT 1");
                        $m = mysqli_fetch_assoc($q_m);
                        $nama_mapel = $m ? $m['nama_mapel'] : 'Belum ada mapel';
                    ?>
                    <option value="<?= $g['id']; ?>"><?= htmlspecialchars($g['nama']); ?> (Mapel: <?= htmlspecialchars($nama_mapel); ?>)</option>
                <?>
                <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="kelas" class="form-label fw-semibold small">Pilih Kelas</label>
            <select name="kelas" id="kelas" class="form-select rounded-3" required>
                <option value="">-- Pilih Kelas --</option>
                <?>
                <?php while ($k = mysqli_fetch_assoc($q_kelas)): ?>
                    <option value="<?= htmlspecialchars($k['kelas']); ?>"><?= htmlspecialchars($k['kelas']); ?></option>
                <?>
                <?php endwhile; ?>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="tabel_mengajar.php" class="btn btn-light rounded-3 px-4">Batal</a>
            <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Data</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>