<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

$kelas    = $_GET['kelas'] ?? '';
$mapel_id = $_GET['mapel_id'] ?? '';

if (empty($kelas) || empty($mapel_id)) {
    header("Location: daftar_kelas_guru.php");
    exit;
}

// Ambil info nama mata pelajaran
$q_mapel = mysqli_query($koneksi, "SELECT nama_mapel FROM mapel WHERE id = '$mapel_id' LIMIT 1");
$d_mapel = mysqli_fetch_assoc($q_mapel);
$nama_mapel = $d_mapel['nama_mapel'] ?? '';

// Ambil seluruh siswa di kelas tersebut (otomatis mencakup siswa baru yang ditambahkan ke kelas ini)
// Disertakan LEFT JOIN ke tabel nilai_rapor untuk mapel terkait
$query = mysqli_query($koneksi, "
    SELECT s.id AS siswa_id, s.nama AS nama_siswa, s.nis, 
           n.id AS nilai_id, n.nilai_kkm, n.nilai_pengetahuan, n.nilai_keterampilan, n.Keterangan
    FROM siswa s
    LEFT JOIN nilai_rapor n ON s.id = n.siswa_id AND n.mapel_id = '$mapel_id'
    WHERE s.kelas = '$kelas'
    ORDER BY s.nama ASC
");

$base       = "../";
$title_page = "Daftar Nilai Siswa - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h3 class="fw-bold mb-1"><i class="bi bi-journal-richtext text-primary me-2"></i>Daftar Nilai Siswa</h3>
      <p class="text-muted mb-0">Kelas: <strong class="text-dark"><?= htmlspecialchars($kelas); ?></strong> | Mata Pelajaran: <strong class="text-dark"><?= htmlspecialchars($nama_mapel); ?></strong></p>
    </div>
    <div>
      <a href="daftar_kelas_guru.php" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
      
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <span class="small text-muted">Tampilkan</span>
          <select class="form-select form-select-sm rounded-3" style="width: 75px;">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
          </select>
          <span class="small text-muted">data per halaman</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="text-muted small">Cari:</span>
          <input type="text" class="form-control form-control-sm rounded-3" style="width: 200px;" placeholder="Pencarian...">
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th width="6%">No</th>
              <th width="24%">Nama Siswa</th>
              <th width="10%" class="text-center">KKM</th>
              <th width="12%" class="text-center">Pengetahuan</th>
              <th width="12%" class="text-center">Keterampilan</th>
              <th width="12%" class="text-center">Nilai Akhir</th>
              <th width="14%">Keterangan</th>
              <th width="10%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            if ($query && mysqli_num_rows($query) > 0):
                while ($row = mysqli_fetch_assoc($query)): 
                    $has_nilai = !empty($row['nilai_id']);
                    // Hitung nilai akhir rata-rata pengetahuan & keterampilan jika ada
                    if ($has_nilai && is_numeric($row['nilai_pengetahuan']) && is_numeric($row['nilai_keterampilan'])) {
                        $nilai_akhir = ($row['nilai_pengetahuan'] + $row['nilai_keterampilan']) / 2;
                    } else {
                        $nilai_akhir = '-';
                    }
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_siswa']); ?></td>
                <td class="text-center"><?= $has_nilai ? $row['nilai_kkm'] : '-'; ?></td>
                <td class="text-center">
                  <?php if ($has_nilai): ?>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-bold"><?= $row['nilai_pengetahuan']; ?></span>
                  <?php else: ?>
                    <span class="text-muted small">Belum ada</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if ($has_nilai): ?>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-bold"><?= $row['nilai_keterampilan']; ?></span>
                  <?php else: ?>
                    <span class="text-muted small">Belum ada</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if ($has_nilai && is_numeric($nilai_akhir)): ?>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-3 fw-bold"><?= number_format($nilai_akhir, 0); ?></span>
                  <?php else: ?>
                    <span class="text-muted small">Belum ada</span>
                  <?php endif; ?>
                </td>
                <td><?= $has_nilai && !empty($row['Keterangan']) ? htmlspecialchars($row['Keterangan']) : '-'; ?></td>
                <td class="text-center">
                  <?php if ($has_nilai): ?>
                    <a href="form_edit_nilai.php?id=<?= $row['nilai_id']; ?>" class="btn btn-sm btn-warning text-dark fw-semibold rounded-2 px-2 py-1 me-1" title="Edit">Edit</a>
                    <a href="aksi_hapus_nilai.php?nilai_id=<?= $row['nilai_id']; ?>&kelas=<?= urlencode($kelas); ?>&mapel_id=<?= $mapel_id; ?>" class="btn btn-sm btn-danger rounded-2 px-2 py-1" onclick="return confirm('Yakin ingin menghapus nilai ini?')" title="Hapus">Hapus</a>
                  <?php else: ?>
                    <a href="form_tambah_nilai.php?siswa_id=<?= $row['siswa_id']; ?>&kelas=<?= urlencode($kelas); ?>&mapel_id=<?= $mapel_id; ?>" class="btn btn-sm btn-primary rounded-2 px-3 py-1">Tambah</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php 
                endwhile;
            else:
            ?>
              <tr>
                <td colspan="8" class="text-center py-4 text-muted">Belum ada data siswa di kelas ini.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
        <span class="text-muted small">Menampilkan halaman 1 dari 1</span>
        <div class="btn-group btn-group-sm">
          <button class="btn btn-outline-secondary rounded-start-3" disabled>Sebelumnya</button>
          <button class="btn btn-primary px-3">1</button>
          <button class="btn btn-outline-secondary rounded-end-3" disabled>Selanjutnya</button>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>