<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../access/login.php");
    exit;
}

require_once("../db/koneksi.php");

$id = $_GET['id'] ?? 0;

// Ambil data user beserta relasinya ke tabel guru atau siswa
$query = mysqli_query($koneksi, "
    SELECT u.*, 
           g.id AS guru_id, g.nip, g.nama AS nama_guru, g.jenis_kelamin AS jk_guru,
           s.id AS siswa_id, s.nis, s.nama AS nama_siswa, s.jenis_kelamin AS jk_siswa, s.kelas
    FROM users u 
    LEFT JOIN guru g ON u.id = g.user_id OR u.username = g.nip 
    LEFT JOIN siswa s ON u.id = s.user_id OR u.username = s.nis 
    WHERE u.id = '$id'
    GROUP BY u.id
");
$d_user = mysqli_fetch_assoc($query);

if (!$d_user) {
    header("Location: tabel_user.php");
    exit;
}

$base       = "../";
$title_page = "Edit User - SIPN";

require_once("../header.php");
require_once("../navbar.php");
?>

<div class="container my-4" style="max-width: 750px;">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h3 class="fw-bold mb-1">Edit Data Pengguna</h3>
          <p class="text-muted small mb-0">Perbarui informasi kredensial akun serta profil terkait (Guru/Siswa/Admin).</p>
        </div>
        <a href="tabel_user.php" class="btn btn-outline-secondary btn-sm rounded-3">
          <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
      </div>

      <form action="aksi_edit_user.php" method="POST">
        <input type="hidden" name="id" value="<?= $d_user['id']; ?>">
        <input type="hidden" name="role" value="<?= $d_user['role']; ?>">
        
        <!-- Informasi Kredensial Akun -->
        <div class="mb-4">
          <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
            <i class="bi bi-person-lock text-primary me-2"></i>Kredensial Akun (Users)
          </h5>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($d_user['username'] ?? ''); ?>" class="form-control rounded-3" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Password Baru <span class="text-muted fw-normal">(Kosongkan jika tidak ingin diubah)</span>:</label>
            <input type="password" name="password" class="form-control rounded-3" placeholder="Masukkan password baru">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Role / Hak Akses:</label>
            <input type="text" class="form-control rounded-3 bg-light text-dark fw-semibold text-uppercase" value="<?= $d_user['role']; ?>" readonly>
          </div>
        </div>

        <!-- Jika Role adalah Guru, tampilkan field Guru -->
        <?php if ($d_user['role'] === 'guru'): ?>
          <input type="hidden" name="guru_id" value="<?= $d_user['guru_id']; ?>">
          <div class="mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
              <i class="bi bi-person-badge text-primary me-2"></i>Profil Guru
            </h5>
            
            <div class="mb-3">
              <label class="form-label fw-semibold small">NIP:</label>
              <input type="text" name="nip" value="<?= htmlspecialchars($d_user['nip'] ?? ''); ?>" class="form-control rounded-3" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Nama Lengkap:</label>
              <input type="text" name="nama" value="<?= htmlspecialchars($d_user['nama_guru'] ?? ''); ?>" class="form-control rounded-3" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Jenis Kelamin:</label>
              <select name="jenis_kelamin" class="form-select rounded-3" required>
                <option value="L" <?= (($d_user['jk_guru'] ?? '') === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?= (($d_user['jk_guru'] ?? '') === 'P') ? 'selected' : ''; ?>>Perempuan</option>
              </select>
            </div>
          </div>
        <?php endif; ?>

        <!-- Jika Role adalah Siswa, tampilkan field Siswa -->
        <?php if ($d_user['role'] === 'siswa'): ?>
          <input type="hidden" name="siswa_id" value="<?= $d_user['siswa_id']; ?>">
          <div class="mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
              <i class="bi bi-person-badge text-primary me-2"></i>Profil Siswa
            </h5>
            
            <div class="mb-3">
              <label class="form-label fw-semibold small">NIS:</label>
              <input type="text" name="nis" value="<?= htmlspecialchars($d_user['nis'] ?? ''); ?>" class="form-control rounded-3" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Nama Lengkap:</label>
              <input type="text" name="nama" value="<?= htmlspecialchars($d_user['nama_siswa'] ?? ''); ?>" class="form-control rounded-3" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Jenis Kelamin:</label>
              <select name="jenis_kelamin" class="form-select rounded-3" required>
                <option value="L" <?= (($d_user['jk_siswa'] ?? '') === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?= (($d_user['jk_siswa'] ?? '') === 'P') ? 'selected' : ''; ?>>Perempuan</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold small">Kelas:</label>
              <input type="text" name="kelas" value="<?= htmlspecialchars($d_user['kelas'] ?? ''); ?>" class="form-control rounded-3" required>
            </div>
          </div>
        <?php endif; ?>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="tabel_user.php" class="btn btn-light rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-primary rounded-3 px-4">Perbarui Data</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>