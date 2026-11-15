<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

// Kueri mengambil data mengajar lengkap dengan nama guru, kelas, nama mapel, dan kode mapel[cite: 7]
$query = "SELECT m.*, mapel.kode_mapel, mapel.nama_mapel, guru.nama AS nama_guru, siswa.kelas 
          FROM mengajar m
          JOIN mapel ON m.mapel_id = mapel.id
          JOIN guru ON mapel.guru_id = guru.id
          JOIN siswa ON m.siswa_id = siswa.id
          GROUP BY m.mapel_id, siswa.kelas 
          ORDER BY m.id DESC";

$result = mysqli_query($koneksi, $query);
$total_data = mysqli_num_rows($result);

$base       = "../";
$title_page = "Data Mengajar - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h3 class="fw-bold mb-1"><i class="bi bi-journal-check text-primary me-2"></i>Daftar Mengajar</h3>
      <p class="text-muted mb-0">Kelola jadwal dan penugasan guru pengampu mata pelajaran per kelas.</p>
    </div>
    <div>
      <a href="form_tambah_mengajar.php" class="btn btn-primary rounded-3 px-3">
        <i class="bi bi-plus-lg me-1"></i> Tambah Mengajar
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
      
      <!-- Filter Tampilkan & Kotak Cari -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <span class="small text-muted">Tampilkan</span>
          <select class="form-select form-select-sm rounded-3" style="width: 75px;">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
          </select>
          <span class="small text-muted">data</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="text-muted small">Cari:</span>
          <input type="text" class="form-control form-control-sm rounded-3" style="width: 200px;" placeholder="Pencarian...">
        </div>
      </div>

      <!-- Tabel Mengajar -->
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th width="6%">No</th>
              <th width="26%">Nama Guru</th>
              <th width="15%">Kelas</th>
              <th width="26%">Nama Mata Pelajaran</th>
              <th width="15%">Kode Mapel</th>
              <th width="12%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($total_data > 0): ?>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) : 
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_guru']); ?></td>
                  <td>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-3 fw-semibold">
                      <?= htmlspecialchars($row['kelas']); ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($row['nama_mapel']); ?></td>
                  <td>
                    <span class="font-monospace text-dark fw-semibold"><?= htmlspecialchars($row['kode_mapel']); ?></span>
                  </td>
                  <td class="text-center">
                    <a href="form_edit_mengajar.php?mapel_id=<?= $row['mapel_id']; ?>&kelas=<?= urlencode($row['kelas']); ?>" class="btn btn-sm btn-outline-primary rounded-2 me-1" title="Edit">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="aksi_hapus_mengajar.php?mapel_id=<?= $row['mapel_id']; ?>&kelas=<?= urlencode($row['kelas']); ?>" class="btn btn-sm btn-outline-danger rounded-2" onclick="return confirm('Yakin ingin menghapus data mengajar kelas ini?')" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data mengajar.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Footer Total & Navigasi -->
      <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
        <span class="text-muted small">Menampilkan total <strong><?= $total_data; ?></strong> data</span>
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