<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

// Kueri presisi dengan relasi ke tabel guru dan siswa
$query = mysqli_query($koneksi, "
    SELECT u.*, 
           COALESCE(g.nama, s.nama, 'Admin') AS nama_lengkap 
    FROM users u 
    LEFT JOIN guru g ON u.id = g.user_id OR u.username = g.nip 
    LEFT JOIN siswa s ON u.id = s.user_id OR u.username = s.nis 
    GROUP BY u.id 
    ORDER BY u.id ASC
");

$base       = "../";
$title_page = "Data User - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h3 class="fw-bold mb-1"><i class="bi bi-people text-primary me-2"></i>Data Pengguna (User)</h3>
      <p class="text-muted mb-0">Kelola akun pengguna, hak akses (role), dan kredensial sistem.</p>
    </div>
    <div>
      <a href="form_tambah_user.php" class="btn btn-primary rounded-3 px-3">
        <i class="bi bi-plus-lg me-1"></i> Tambah User
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
              <th width="27%">Username</th>
              <th width="33%">Nama Lengkap / Pemilik</th>
              <th width="20%">Role / Hak Akses</th>
              <th width="12%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($query) > 0):
                while ($row = mysqli_fetch_assoc($query)): 
                    // Tentukan warna badge berdasarkan role
                    $role_badge = 'bg-secondary bg-opacity-10 text-secondary';
                    if ($row['role'] === 'admin') {
                        $role_badge = 'bg-danger bg-opacity-10 text-danger';
                    } elseif ($row['role'] === 'guru') {
                        $role_badge = 'bg-primary bg-opacity-10 text-primary';
                    } elseif ($row['role'] === 'siswa') {
                        $role_badge = 'bg-success bg-opacity-10 text-success';
                    }
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td>
                  <span class="fw-semibold text-dark font-monospace"><?= htmlspecialchars($row['username']); ?></span>
                </td>
                <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                <td>
                  <span class="badge <?= $role_badge; ?> px-3 py-2 rounded-3 text-uppercase fw-bold" style="font-size: 0.75rem;">
                    <?= htmlspecialchars($row['role']); ?>
                  </span>
                </td>
                <td class="text-center">
                  <a href="form_edit_user.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary rounded-2 me-1" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a href="aksi_hapus_user.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-2" onclick="return confirm('Yakin ingin menghapus user ini?')" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php 
                endwhile;
            else:
            ?>
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">Belum ada data user.</td>
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