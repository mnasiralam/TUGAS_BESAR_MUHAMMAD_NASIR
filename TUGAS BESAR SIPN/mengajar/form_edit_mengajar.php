<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}
require_once("../db/koneksi.php");

$old_mapel_id = $_GET['mapel_id'] ?? '';
$old_kelas    = $_GET['kelas'] ?? '';

if (empty($old_mapel_id) || empty($old_kelas)) {
    header("Location: tabel_mengajar.php");
    exit;
}

// Ambil data guru yang saat ini mengampu mapel tersebut[cite: 5]
$q_current = mysqli_query($koneksi, "SELECT mapel.*, guru.id as id_guru FROM mapel JOIN guru ON mapel.guru_id = guru.id WHERE mapel.id = '$old_mapel_id'");
$d_current = mysqli_fetch_assoc($q_current);
$current_guru_id = $d_current ? $d_current['id_guru'] : '';

// Ambil data guru untuk pilihan dropdown[cite: 5]
$q_guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nama ASC");

// Ambil daftar kelas unik dari tabel siswa[cite: 5]
$q_kelas = mysqli_query($koneksi, "SELECT DISTINCT kelas FROM siswa WHERE kelas != '' ORDER BY kelas ASC");

$base       = "../";
$title_page = "Edit Mengajar - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 700px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Form Edit Mengajar</h3>
          <p class="text-muted small mb-0">Ubah penugasan guru dan/atau kelas untuk mata pelajaran terkait.</p>
        </div>
        <a href="tabel_mengajar.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_edit_mengajar.php" method="POST">
          <input type="hidden" name="old_mapel_id" value="<?= htmlspecialchars($old_mapel_id); ?>">
          <input type="hidden" name="old_kelas" value="<?= htmlspecialchars($old_kelas); ?>">

          <div class="mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
              <i class="bi bi-journal-text text-primary me-2"></i>Perbarui Penugasan
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
                            $selected = ($id_g == $current_guru_id) ? 'selected' : '';
                        ?>
                        <option value="<?= $g['id']; ?>" <?= $selected; ?>><?= htmlspecialchars($g['nama']); ?> (Mapel: <?= htmlspecialchars($nama_mapel); ?>)</option>
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
                        <?php $selected_k = ($k['kelas'] == $old_kelas) ? 'selected' : ''; ?>
                        <option value="<?= htmlspecialchars($k['kelas']); ?>" <?= $selected_k; ?>><?= htmlspecialchars($k['kelas']); ?></option>
                    <?>
                    <?php endwhile; ?>
                </select>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
              <a href="tabel_mengajar.php" class="btn btn-light rounded-3 px-4">Batal</a>
              <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Perubahan</button>
          </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>