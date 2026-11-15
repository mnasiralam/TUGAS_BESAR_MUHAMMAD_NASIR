<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$username = $_SESSION['username'];
$q_siswa  = mysqli_query($koneksi, "SELECT id, nama, kelas FROM siswa WHERE user_id = '{$_SESSION['user_id']}' OR nis = '$username' LIMIT 1");
$d_siswa  = mysqli_fetch_assoc($q_siswa);
$siswa_id = $d_siswa['id'] ?? 0;


$q_nilai = mysqli_query($koneksi, "
    SELECT mp.nama_mapel, g.nama AS nama_guru, n.nilai_kkm, n.nilai_pengetahuan, n.nilai_keterampilan, n.Keterangan
    FROM nilai_rapor n
    JOIN mapel mp ON n.mapel_id = mp.id
    LEFT JOIN guru g ON mp.guru_id = g.id
    WHERE n.siswa_id = '$siswa_id'
");

$base       = "../";
$title_page = "Nilai Saya - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h3 class="fw-bold mb-1"><i class="bi bi-award text-primary me-2"></i>Laporan Nilai Saya</h3>
      <p class="text-muted mb-0">Kelas: <strong class="text-dark"><?= htmlspecialchars($d_siswa['kelas'] ?? '-'); ?></strong></p>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th width="6%">No</th>
              <th width="26%">Mata Pelajaran</th>
              <th width="24%">Guru Pengampu</th>
              <th class="text-center" width="10%">KKM</th>
              <th class="text-center" width="10%">Pengetahuan</th>
              <th class="text-center" width="10%">Keterampilan</th>
              <th class="text-center" width="14%">Nilai Akhir</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            if ($q_nilai && mysqli_num_rows($q_nilai) > 0):
                while ($row = mysqli_fetch_assoc($q_nilai)): 
                    // Hitung nilai akhir rata-rata pengetahuan & keterampilan
                    if (is_numeric($row['nilai_pengetahuan']) && is_numeric($row['nilai_keterampilan'])) {
                        $nilai_akhir = ($row['nilai_pengetahuan'] + $row['nilai_keterampilan']) / 2;
                    } else {
                        $nilai_akhir = 0;
                    }
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_mapel']); ?></td>
                <td class="text-muted"><?= htmlspecialchars($row['nama_guru'] ?? '-'); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['nilai_kkm']); ?></td>
                <td class="text-center">
                  <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-bold"><?= $row['nilai_pengetahuan']; ?></span>
                </td>
                <td class="text-center">
                  <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-bold"><?= $row['nilai_keterampilan']; ?></span>
                </td>
                <td class="text-center">
                  <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-3 fw-bold">
                    <?= number_format($nilai_akhir, 0); ?>
                  </span>
                </td>
              </tr>
            <?php 
                endwhile;
            else:
            ?>
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">Belum ada nilai yang diinput oleh guru.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>