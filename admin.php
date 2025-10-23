<?php
include 'config.php';
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// helper fungsi untuk set toast via session
function set_toast($msg){
    $_SESSION['toast'] = $msg;
}

// --- HANDLE ACTIONS ---
// NEGARA tambah, soft delete, restore, permanent delete
if(isset($_POST['tambah_negara'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_negara']);
    mysqli_query($conn, "INSERT INTO negara (nama_negara) VALUES ('$nama')");
    set_toast("Negara berhasil ditambahkan.");
    header("Location: admin.php#negara");
    exit;
}
if(isset($_GET['hapus_negara'])){
    $id = (int)$_GET['hapus_negara'];
    $admin_id = (int)$_SESSION['admin_id'];
    mysqli_query($conn, "UPDATE negara SET deleted_at=NOW(), deleted_by=$admin_id WHERE id_negara=$id");
    set_toast("Negara dipindahkan ke Sampah.");
    header("Location: admin.php#negara");
    exit;
}
if(isset($_GET['restore_negara'])){
    $id = (int)$_GET['restore_negara'];
    mysqli_query($conn, "UPDATE negara SET deleted_at=NULL, deleted_by=NULL WHERE id_negara=$id");
    set_toast("Negara berhasil dipulihkan.");
    header("Location: admin.php?tab=sampah");
    exit;
}
if(isset($_GET['deletepermanen_negara'])){
    $id = (int)$_GET['deletepermanen_negara'];
    mysqli_query($conn, "DELETE FROM negara WHERE id_negara=$id");
    set_toast("Negara dihapus permanen.");
    header("Location: admin.php?tab=sampah");
    exit;
}

// PROVINSI
if(isset($_POST['tambah_provinsi'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_provinsi']);
    $id_negara = (int)$_POST['id_negara'];
    mysqli_query($conn, "INSERT INTO provinsi (id_negara, nama_provinsi) VALUES ('$id_negara','$nama')");
    set_toast("Provinsi berhasil ditambahkan.");
    header("Location: admin.php#provinsi");
    exit;
}
if(isset($_GET['hapus_provinsi'])){
    $id = (int)$_GET['hapus_provinsi'];
    $admin_id = (int)$_SESSION['admin_id'];
    mysqli_query($conn, "UPDATE provinsi SET deleted_at=NOW(), deleted_by=$admin_id WHERE id_provinsi=$id");
    set_toast("Provinsi dipindahkan ke Sampah.");
    header("Location: admin.php#provinsi");
    exit;
}
if(isset($_GET['restore_provinsi'])){
    $id = (int)$_GET['restore_provinsi'];
    mysqli_query($conn, "UPDATE provinsi SET deleted_at=NULL, deleted_by=NULL WHERE id_provinsi=$id");
    set_toast("Provinsi berhasil dipulihkan.");
    header("Location: admin.php?tab=sampah");
    exit;
}
if(isset($_GET['deletepermanen_provinsi'])){
    $id = (int)$_GET['deletepermanen_provinsi'];
    mysqli_query($conn, "DELETE FROM provinsi WHERE id_provinsi=$id");
    set_toast("Provinsi dihapus permanen.");
    header("Location: admin.php?tab=sampah");
    exit;
}

// KOTA
if(isset($_POST['tambah_kota'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kota']);
    $id_provinsi = (int)$_POST['id_provinsi'];
    mysqli_query($conn, "INSERT INTO kota (id_provinsi, nama_kota) VALUES ('$id_provinsi','$nama')");
    set_toast("Kota berhasil ditambahkan.");
    header("Location: admin.php#kota");
    exit;
}
if(isset($_GET['hapus_kota'])){
    $id = (int)$_GET['hapus_kota'];
    $admin_id = (int)$_SESSION['admin_id'];
    mysqli_query($conn, "UPDATE kota SET deleted_at=NOW(), deleted_by=$admin_id WHERE id_kota=$id");
    set_toast("Kota dipindahkan ke Sampah.");
    header("Location: admin.php#kota");
    exit;
}
if(isset($_GET['restore_kota'])){
    $id = (int)$_GET['restore_kota'];
    mysqli_query($conn, "UPDATE kota SET deleted_at=NULL, deleted_by=NULL WHERE id_kota=$id");
    set_toast("Kota berhasil dipulihkan.");
    header("Location: admin.php?tab=sampah");
    exit;
}
if(isset($_GET['deletepermanen_kota'])){
    $id = (int)$_GET['deletepermanen_kota'];
    mysqli_query($conn, "DELETE FROM kota WHERE id_kota=$id");
    set_toast("Kota dihapus permanen.");
    header("Location: admin.php?tab=sampah");
    exit;
}

// PEMERINTAHAN
if(isset($_POST['tambah_pemerintahan'])){
    $id_negara = (int)$_POST['id_negara'];
    $sistem = mysqli_real_escape_string($conn, $_POST['sistem_pemerintahan']);
    mysqli_query($conn, "INSERT INTO jenis_pemerintahan (id_negara, sistem_pemerintahan) VALUES ('$id_negara','$sistem')");
    set_toast("Jenis pemerintahan berhasil ditambahkan.");
    header("Location: admin.php#pemerintahan");
    exit;
}
if(isset($_GET['hapus_pemerintahan'])){
    $id = (int)$_GET['hapus_pemerintahan'];
    $admin_id = (int)$_SESSION['admin_id'];
    mysqli_query($conn, "UPDATE jenis_pemerintahan SET deleted_at=NOW(), deleted_by=$admin_id WHERE id_pemerintahan=$id");
    set_toast("Jenis pemerintahan dipindahkan ke Sampah.");
    header("Location: admin.php#pemerintahan");
    exit;
}
if(isset($_GET['restore_pemerintahan'])){
    $id = (int)$_GET['restore_pemerintahan'];
    mysqli_query($conn, "UPDATE jenis_pemerintahan SET deleted_at=NULL, deleted_by=NULL WHERE id_pemerintahan=$id");
    set_toast("Jenis pemerintahan berhasil dipulihkan.");
    header("Location: admin.php?tab=sampah");
    exit;
}
if(isset($_GET['deletepermanen_pemerintahan'])){
    $id = (int)$_GET['deletepermanen_pemerintahan'];
    mysqli_query($conn, "DELETE FROM jenis_pemerintahan WHERE id_pemerintahan=$id");
    set_toast("Jenis pemerintahan dihapus permanen.");
    header("Location: admin.php?tab=sampah");
    exit;
}

// ADMIN management (multi-admin)
if(isset($_POST['tambah_admin'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    // hash password dengan bcrypt agar aman
    $hash = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO admin (username, password) VALUES ('$username', '$hash')");
    set_toast("Admin baru berhasil ditambahkan.");
    header("Location: admin.php#admin_manage");
    exit;
}
if(isset($_GET['hapus_admin'])){
    $id = (int)$_GET['hapus_admin'];
    // untuk keamanan, jangan hapus diri sendiri
    if($id == (int)$_SESSION['admin_id']){
        set_toast("Tidak bisa menghapus akun yang sedang login.");
    } else {
        mysqli_query($conn, "DELETE FROM admin WHERE id_admin=$id");
        set_toast("Admin dihapus.");
    }
    header("Location: admin.php#admin_manage");
    exit;
}

// ambil statistik
$stat_negara = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM negara WHERE deleted_at IS NULL"))['cnt'];
$stat_provinsi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM provinsi WHERE deleted_at IS NULL"))['cnt'];
$stat_kota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM kota WHERE deleted_at IS NULL"))['cnt'];
$stat_pemerintahan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM jenis_pemerintahan WHERE deleted_at IS NULL"))['cnt'];

// ambil data aktif
$neg_q = mysqli_query($conn, "SELECT * FROM negara WHERE deleted_at IS NULL ORDER BY nama_negara");
$prov_q = mysqli_query($conn, "SELECT p.*, n.nama_negara FROM provinsi p JOIN negara n ON p.id_negara=n.id_negara WHERE p.deleted_at IS NULL ORDER BY p.nama_provinsi");
$kota_q = mysqli_query($conn, "SELECT k.*, p.nama_provinsi FROM kota k JOIN provinsi p ON k.id_provinsi=p.id_provinsi WHERE k.deleted_at IS NULL ORDER BY k.nama_kota");
$pem_q = mysqli_query($conn, "SELECT j.*, n.nama_negara FROM jenis_pemerintahan j JOIN negara n ON j.id_negara=n.id_negara WHERE j.deleted_at IS NULL ORDER BY j.sistem_pemerintahan");

// ambil admin list
$admins_q = mysqli_query($conn, "SELECT * FROM admin ORDER BY username");

// ambil data sampah (deleted)
$sampah_negara_q = mysqli_query($conn, "SELECT * FROM negara WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
$sampah_prov_q = mysqli_query($conn, "SELECT p.*, n.nama_negara FROM provinsi p JOIN negara n ON p.id_negara=n.id_negara WHERE p.deleted_at IS NOT NULL ORDER BY p.deleted_at DESC");
$sampah_kota_q = mysqli_query($conn, "SELECT k.*, p.nama_provinsi FROM kota k JOIN provinsi p ON k.id_provinsi=p.id_provinsi WHERE k.deleted_at IS NOT NULL ORDER BY k.deleted_at DESC");
$sampah_pem_q = mysqli_query($conn, "SELECT j.*, n.nama_negara FROM jenis_pemerintahan j JOIN negara n ON j.id_negara=n.id_negara WHERE j.deleted_at IS NOT NULL ORDER BY j.deleted_at DESC");

// handle toasts
$toast = null;
if(isset($_SESSION['toast'])){
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="style.css">
<style>
.stats {
  display:flex;
  gap:12px;
  margin-bottom:18px;
}
.stat-card {
  flex:1;
  background: #f7fff9;
  padding:12px;
  border-radius:8px;
  text-align:center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.stat-card h3 { margin:0; color:var(--primary); }
.stat-card p { margin:6px 0 0 0; font-size:14px; color:#333; }
.top-actions { display:flex; gap:8px; justify-content:flex-end; margin-bottom:8px; }
</style>
</head>
<body>

<header>
  <h1>Dashboard Admin</h1>
  <div style="display:flex;gap:8px;align-items:center;">
    <button id="themeToggle" class="btn-add">Toggle Theme</button>
    <a href="logout.php" class="btn-logout">Logout</a>
  </div>
</header>

<main>
  <div class="stats">
    <div class="stat-card">
      <h3><?= $stat_negara ?></h3>
      <p>Negara</p>
    </div>
    <div class="stat-card">
      <h3><?= $stat_provinsi ?></h3>
      <p>Provinsi</p>
    </div>
    <div class="stat-card">
      <h3><?= $stat_kota ?></h3>
      <p>Kota</p>
    </div>
    <div class="stat-card">
      <h3><?= $stat_pemerintahan ?></h3>
      <p>Jenis Pemerintahan</p>
    </div>
  </div>

  <div class="tab-menu">
    <button onclick="showTab('negara')">Negara</button>
    <button onclick="showTab('provinsi')">Provinsi</button>
    <button onclick="showTab('kota')">Kota</button>
    <button onclick="showTab('pemerintahan')">Jenis Pemerintahan</button>
    <button onclick="showTab('admin_manage')">Admin</button>
    <button onclick="showTab('sampah')">Lihat Data Terhapus</button>
  </div>

  <!-- TABEL NEGARA -->
  <div id="negara" class="tab-content active">
    <h2>Data Negara</h2>
    <form method="POST" style="display:flex;gap:8px;align-items:center;">
      <input type="text" name="nama_negara" placeholder="Nama Negara" required>
      <button type="submit" name="tambah_negara" class="btn-add">Tambah</button>
    </form>
    <table>
      <tr><th>No</th><th>Nama Negara</th><th>Aksi</th></tr>
      <?php $no=1; while($r=mysqli_fetch_assoc($neg_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($r['nama_negara']) ?></td>
        <td class="actions">
          <a href="?hapus_negara=<?= $r['id_negara'] ?>" onclick="return confirm('Pindahkan ke sampah?')">Hapus</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>
  </div>

  <!-- TABEL PROVINSI -->
  <div id="provinsi" class="tab-content">
    <h2>Data Provinsi</h2>
    <form method="POST" style="display:flex;gap:8px;align-items:center;">
      <input type="text" name="nama_provinsi" placeholder="Nama Provinsi" required>
      <select name="id_negara" required>
        <option value="">Pilih Negara</option>
        <?php
        $neg2 = mysqli_query($conn,"SELECT id_negara, nama_negara FROM negara WHERE deleted_at IS NULL ORDER BY nama_negara");
        while($n=mysqli_fetch_assoc($neg2)) echo "<option value='{$n['id_negara']}'>{$n['nama_negara']}</option>";
        ?>
      </select>
      <button type="submit" name="tambah_provinsi" class="btn-add">Tambah</button>
    </form>
    <table>
      <tr><th>No</th><th>Nama Provinsi</th><th>Negara</th><th>Aksi</th></tr>
      <?php $no=1; while($r=mysqli_fetch_assoc($prov_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($r['nama_provinsi']) ?></td>
        <td><?= htmlspecialchars($r['nama_negara']) ?></td>
        <td class="actions">
          <a href="?hapus_provinsi=<?= $r['id_provinsi'] ?>" onclick="return confirm('Pindahkan ke sampah?')">Hapus</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>
  </div>

  <!-- TABEL KOTA -->
  <div id="kota" class="tab-content">
    <h2>Data Kota</h2>
    <form method="POST" style="display:flex;gap:8px;align-items:center;">
      <input type="text" name="nama_kota" placeholder="Nama Kota" required>
      <select name="id_provinsi" required>
        <option value="">Pilih Provinsi</option>
        <?php
        $pr2 = mysqli_query($conn,"SELECT id_provinsi, nama_provinsi FROM provinsi WHERE deleted_at IS NULL ORDER BY nama_provinsi");
        while($p=mysqli_fetch_assoc($pr2)) echo "<option value='{$p['id_provinsi']}'>{$p['nama_provinsi']}</option>";
        ?>
      </select>
      <button type="submit" name="tambah_kota" class="btn-add">Tambah</button>
    </form>
    <table>
      <tr><th>No</th><th>Nama Kota</th><th>Provinsi</th><th>Aksi</th></tr>
      <?php $no=1; while($r=mysqli_fetch_assoc($kota_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($r['nama_kota']) ?></td>
        <td><?= htmlspecialchars($r['nama_provinsi']) ?></td>
        <td class="actions">
          <a href="?hapus_kota=<?= $r['id_kota'] ?>" onclick="return confirm('Pindahkan ke sampah?')">Hapus</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>
  </div>

  <!-- TABEL JENIS PEMERINTAHAN -->
  <div id="pemerintahan" class="tab-content">
    <h2>Data Jenis Pemerintahan</h2>
    <form method="POST" style="display:flex;gap:8px;align-items:center;">
      <select name="id_negara" required>
        <option value="">Pilih Negara</option>
        <?php
        $neg3 = mysqli_query($conn,"SELECT id_negara, nama_negara FROM negara WHERE deleted_at IS NULL ORDER BY nama_negara");
        while($n=mysqli_fetch_assoc($neg3)) echo "<option value='{$n['id_negara']}'>{$n['nama_negara']}</option>";
        ?>
      </select>
      <input type="text" name="sistem_pemerintahan" placeholder="Jenis Pemerintahan" required>
      <button type="submit" name="tambah_pemerintahan" class="btn-add">Tambah</button>
    </form>
    <table>
      <tr><th>No</th><th>Negara</th><th>Jenis Pemerintahan</th><th>Aksi</th></tr>
      <?php $no=1; while($r=mysqli_fetch_assoc($pem_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($r['nama_negara']) ?></td>
        <td><?= htmlspecialchars($r['sistem_pemerintahan']) ?></td>
        <td class="actions">
          <a href="?hapus_pemerintahan=<?= $r['id_pemerintahan'] ?>" onclick="return confirm('Pindahkan ke sampah?')">Hapus</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>
  </div>

  <!-- ADMIN MANAGEMENT -->
  <div id="admin_manage" class="tab-content">
    <h2>Kelola Admin</h2>
    <form method="POST" style="display:flex;gap:8px;align-items:center;">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="tambah_admin" class="btn-add">Tambah Admin</button>
    </form>

    <table>
      <tr><th>No</th><th>Username</th><th>Aksi</th></tr>
      <?php $no=1; while($a=mysqli_fetch_assoc($admins_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($a['username']) ?></td>
        <td class="actions">
          <?php if($a['id_admin'] != $_SESSION['admin_id']): ?>
            <a href="?hapus_admin=<?= $a['id_admin'] ?>" onclick="return confirm('Hapus admin ini?')">Hapus</a>
          <?php else: ?>
            <em>(sedang login)</em>
          <?php endif; ?>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>
  </div>

  <!-- SAMPAH (Recycle Bin) -->
  <div id="sampah" class="tab-content">
    <h2>Data Terhapus (Sampah)</h2>

    <h3>Negara</h3>
    <table>
      <tr><th>No</th><th>Nama Negara</th><th>Dihapus Pada</th><th>Aksi</th></tr>
      <?php $no=1; while($s=mysqli_fetch_assoc($sampah_negara_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($s['nama_negara']) ?></td>
        <td><?= $s['deleted_at'] ?></td>
        <td class="actions">
          <a href="?restore_negara=<?= $s['id_negara'] ?>">Restore</a>
          <a href="?deletepermanen_negara=<?= $s['id_negara'] ?>" onclick="return confirm('Hapus permanen?')">Hapus Permanen</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>

    <h3>Provinsi</h3>
    <table>
      <tr><th>No</th><th>Provinsi</th><th>Negara</th><th>Dihapus Pada</th><th>Aksi</th></tr>
      <?php $no=1; while($s=mysqli_fetch_assoc($sampah_prov_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($s['nama_provinsi']) ?></td>
        <td><?= htmlspecialchars($s['nama_negara']) ?></td>
        <td><?= $s['deleted_at'] ?></td>
        <td class="actions">
          <a href="?restore_provinsi=<?= $s['id_provinsi'] ?>">Restore</a>
          <a href="?deletepermanen_provinsi=<?= $s['id_provinsi'] ?>" onclick="return confirm('Hapus permanen?')">Hapus Permanen</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>

    <h3>Kota</h3>
    <table>
      <tr><th>No</th><th>Kota</th><th>Provinsi</th><th>Dihapus Pada</th><th>Aksi</th></tr>
      <?php $no=1; while($s=mysqli_fetch_assoc($sampah_kota_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($s['nama_kota']) ?></td>
        <td><?= htmlspecialchars($s['nama_provinsi']) ?></td>
        <td><?= $s['deleted_at'] ?></td>
        <td class="actions">
          <a href="?restore_kota=<?= $s['id_kota'] ?>">Restore</a>
          <a href="?deletepermanen_kota=<?= $s['id_kota'] ?>" onclick="return confirm('Hapus permanen?')">Hapus Permanen</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>

    <h3>Jenis Pemerintahan</h3>
    <table>
      <tr><th>No</th><th>Negara</th><th>Jenis</th><th>Dihapus Pada</th><th>Aksi</th></tr>
      <?php $no=1; while($s=mysqli_fetch_assoc($sampah_pem_q)): ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= htmlspecialchars($s['nama_negara']) ?></td>
        <td><?= htmlspecialchars($s['sistem_pemerintahan']) ?></td>
        <td><?= $s['deleted_at'] ?></td>
        <td class="actions">
          <a href="?restore_pemerintahan=<?= $s['id_pemerintahan'] ?>">Restore</a>
          <a href="?deletepermanen_pemerintahan=<?= $s['id_pemerintahan'] ?>" onclick="return confirm('Hapus permanen?')">Hapus Permanen</a>
        </td>
      </tr>
      <?php $no++; endwhile; ?>
    </table>

  </div>

</main>

<!-- Toast container -->
<div id="toast" style="position:fixed;right:20px;bottom:20px;z-index:9999;display:none;padding:12px 16px;border-radius:8px;background:rgba(0,0,0,0.8);color:#fff;"></div>

<script>
function showTab(tabName){
  document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  document.getElementById(tabName).classList.add('active');
  // update URL hash so reload returns to same tab
  history.replaceState(null, null, '#'+tabName);
}

// theme toggle
function applyTheme(){
    var theme = localStorage.getItem('theme') || 'light';
    if(theme === 'dark') document.body.classList.add('dark-mode'); else document.body.classList.remove('dark-mode');
}
document.getElementById('themeToggle').addEventListener('click', function(){
    var t = localStorage.getItem('theme') === 'dark' ? 'light' : 'dark';
    localStorage.setItem('theme', t);
    applyTheme();
});
applyTheme();

// show toast if ada
<?php if($toast): ?>
  (function(){
    var tk = document.getElementById('toast');
    tk.innerText = <?= json_encode($toast) ?>;
    tk.style.display = 'block';
    tk.style.opacity = 1;
    setTimeout(function(){
      tk.style.transition = 'opacity 0.5s';
      tk.style.opacity = 0;
      setTimeout(()=> tk.style.display='none', 500);
    }, 2500);
  })();
<?php endif; ?>

// open tab from query param or hash
(function(){
  var urlParams = new URLSearchParams(window.location.search);
  if(urlParams.has('tab') && urlParams.get('tab') === 'sampah') showTab('sampah');
  if(window.location.hash){
    var h = window.location.hash.substring(1);
    if(document.getElementById(h)) showTab(h);
  }
})();
</script>

</body>
</html>
