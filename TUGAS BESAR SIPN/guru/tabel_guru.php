<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

// Kueri presisi menggunakan relasi user_id dan mapel
$query = mysqli_query($koneksi, "
    SELECT g.*, 
           COALESCE(u.username, '-') AS username_user, 
           COALESCE(m.nama_mapel, 'Belum ada mapel') AS nama_mapel 
    FROM guru g 
    LEFT JOIN users u ON g.user_id = u.id 
    LEFT JOIN mapel m ON g.id = m.guru_id 
    GROUP BY g.id 
    ORDER BY g.id ASC
");

$base       = "../";
$title_page = "Data Guru - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h3 class="fw-bold mb-1"><i class="bi bi-person-workspace text-primary me-2"></i>Data Guru</h3>
      <p class="text-muted mb-0">Kelola data seluruh guru terdaftar dalam sistem.</p>
    </div>
    <div>
      <a href="form_tambah_guru.php" class="btn btn-primary rounded-3 px-3">
        <i class="bi bi-plus-lg me-1"></i> Tambah Guru
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th width="8%">No</th>
              <th width="18%">NIP</th>
              <th width="27%">Nama Lengkap</th>
              <th width="17%">Username</th>
              <th width="20%">Mata Pelajaran</th>
              <th width="10%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($query) > 0):
                while ($row = mysqli_fetch_assoc($query)): 
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="text-muted"><?= htmlspecialchars($row['nip']); ?></td>
                <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama']); ?></td>
                <td><span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-2 font-monospace"><?= htmlspecialchars($row['username_user']); ?></span></td>
                <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-semibold"><?= htmlspecialchars($row['nama_mapel']); ?></span></td>
                <td class="text-center">
                  <a href="form_edit_guru.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary rounded-2 me-1" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a href="aksi_hapus_guru.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-2" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php 
                endwhile;
            else:
            ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">Belum ada data guru.</td>
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