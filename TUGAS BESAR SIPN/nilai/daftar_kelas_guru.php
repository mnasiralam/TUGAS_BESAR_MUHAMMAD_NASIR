<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../index.php';</script>";
    exit;
}

require_once("../db/koneksi.php");

$username = $_SESSION['username'];
$q_guru   = mysqli_query($koneksi, "SELECT id, nama FROM guru WHERE user_id = '{$_SESSION['user_id']}' OR nip = '$username' LIMIT 1");
$d_guru   = mysqli_fetch_assoc($q_guru);
$guru_id  = $d_guru['id'] ?? 0;

// Kueri disesuaikan murni berdasarkan data dari tabel mengajar & mapel yang diampu oleh guru tersebut
$q_mengajar = mysqli_query($koneksi, "
    SELECT m.id AS mengajar_id, mp.id AS mapel_id, mp.nama_mapel, s.kelas 
    FROM mengajar m
    JOIN mapel mp ON m.mapel_id = mp.id
    JOIN siswa s ON m.siswa_id = s.id
    WHERE mp.guru_id = '$guru_id' AND s.kelas != ''
    GROUP BY s.kelas, mp.id
    ORDER BY s.kelas ASC, mp.nama_mapel ASC
");

$base       = "../";
$title_page = "Daftar Kelas yang Diajar - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h3 class="fw-bold mb-1"><i class="bi bi-journal-text text-primary me-2"></i>Daftar Kelas yang Diajar</h3>
      <p class="text-muted mb-0">Pilih kelas dan mata pelajaran sesuai penugasan mengajar untuk mengelola nilai siswa.</p>
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
              <th width="8%">No</th>
              <th width="30%">Kelas</th>
              <th width="32%">Mata Pelajaran</th>
              <th width="20%">Jumlah Siswa</th>
              <th width="10%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            if ($q_mengajar && mysqli_num_rows($q_mengajar) > 0):
                while ($row = mysqli_fetch_assoc($q_mengajar)): 
                    $kelas_tujuan = $row['kelas'];
                    $mapel_id     = $row['mapel_id'];
                    
                    // Hitung jumlah siswa pada kelas tersebut
                    $q_jml = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa WHERE kelas = '$kelas_tujuan'");
                    $d_jml = mysqli_fetch_assoc($q_jml);
                    $jumlah_siswa = $d_jml['total'] ?? 0;
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="fw-semibold text-dark"><?= htmlspecialchars($kelas_tujuan); ?></td>
                <td><?= htmlspecialchars($row['nama_mapel']); ?></td>
                <td><span class="text-muted"><?= $jumlah_siswa; ?> siswa</span></td>
                <td class="text-center">
                  <a href="nilai_siswa_guru.php?kelas=<?= urlencode($kelas_tujuan); ?>&mapel_id=<?= $mapel_id; ?>" class="btn btn-primary btn-sm rounded-3 px-3">
                    Lihat
                  </a>
                </td>
              </tr>
            <?php 
                endwhile;
            else:
            ?>
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">Belum ada penugasan kelas mengajar untuk Anda.</td>
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