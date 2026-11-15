<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

$id = $_GET['id'] ?? 0;
$q_nilai = mysqli_query($koneksi, "
    SELECT n.*, s.nama AS nama_siswa, s.kelas, mp.nama_mapel 
    FROM nilai_rapor n
    JOIN siswa s ON n.siswa_id = s.id
    JOIN mapel mp ON n.mapel_id = mp.id
    WHERE n.id = '$id'
");
$d = mysqli_fetch_assoc($q_nilai);

if (!$d) {
    header("Location: daftar_kelas_guru.php");
    exit;
}

$base       = "../";
$title_page = "Edit Nilai Siswa - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 650px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Nilai Siswa</h3>
          <p class="text-muted small mb-0">
            Siswa: <strong class="text-dark"><?= htmlspecialchars($d['nama_siswa']); ?></strong> | 
            Kelas: <strong class="text-dark"><?= htmlspecialchars($d['kelas']); ?></strong>
          </p>
        </div>
        <a href="nilai_siswa_guru.php?kelas=<?= urlencode($d['kelas']); ?>&mapel_id=<?= $d['mapel_id']; ?>" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_edit_nilai.php" method="POST">
        <input type="hidden" name="nilai_id" value="<?= $d['id']; ?>">
        <input type="hidden" name="kelas" value="<?= htmlspecialchars($d['kelas']); ?>">
        <input type="hidden" name="mapel_id" value="<?= $d['mapel_id']; ?>">

        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-award text-primary me-2"></i>Perbarui Komponen Penilaian (<?= htmlspecialchars($d['nama_mapel']); ?>)
          </h5>

          <div class="mb-3">
            <label for="nilai_kkm" class="form-label fw-semibold small">Nilai KKM</label>
            <input type="number" step="0.01" min="0" max="100" name="nilai_kkm" id="nilai_kkm" value="<?= htmlspecialchars($d['nilai_kkm']); ?>" class="form-control rounded-3" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nilai_pengetahuan" class="form-label fw-semibold small">Nilai Pengetahuan</label>
              <input type="number" step="0.01" min="0" max="100" name="nilai_pengetahuan" id="nilai_pengetahuan" value="<?= htmlspecialchars($d['nilai_pengetahuan']); ?>" class="form-control rounded-3" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="nilai_keterampilan" class="form-label fw-semibold small">Nilai Keterampilan</label>
              <input type="number" step="0.01" min="0" max="100" name="nilai_keterampilan" id="nilai_keterampilan" value="<?= htmlspecialchars($d['nilai_keterampilan']); ?>" class="form-control rounded-3" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="Keterangan" class="form-label fw-semibold small">Keterangan / Catatan</label>
            <textarea name="Keterangan" id="Keterangan" class="form-control rounded-3" rows="3"><?= htmlspecialchars($d['Keterangan']); ?></textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="nilai_siswa_guru.php?kelas=<?= urlencode($d['kelas']); ?>&mapel_id=<?= $d['mapel_id']; ?>" class="btn btn-light rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-primary rounded-3 px-4">Perbarui Nilai</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>