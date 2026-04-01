<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Atur Profil – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/pengaturan.css"/>
</head>
<body>
<?php
session_start();
if (empty($_SESSION['is_logged_in'])) { header('Location: login.php'); exit; }
require_once __DIR__ . '/../src/db/lms.php';

// Tentukan tabel berdasarkan flag session LoginHandler
if (!empty($_SESSION['user_is_driver']))         $table = 'driver';
elseif (!empty($_SESSION['user_is_maintainer']))  $table = 'maintainer';
else                                              $table = 'central_office';

$uid  = (int)$_SESSION['user_id'];
$res  = $db->query("SELECT username FROM `$table` WHERE id=$uid LIMIT 1");
$nama = ($res && $res->num_rows > 0) ? $res->fetch_assoc()['username'] : '';
?>
<div class="shell">
  <div class="topbar">
    <a href="pengaturan.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Atur Profil</h1>
  </div>
  <div class="page-body">

    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status']==='saved'): ?><p class="msg success">Nama berhasil disimpan.</p>
      <?php elseif ($_GET['status']==='error'): ?><p class="msg error">Terjadi kesalahan.</p>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Profil: hanya nama saja -->
    <form class="form-card" action="../src/feature/setting/endpoint/save_profile.php" method="POST">
      <div class="field-group">
        <label>Nama</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($nama) ?>"
               placeholder="Masukkan nama" required/>
      </div>
      <button type="submit" class="btn-save">Simpan</button>
    </form>

  </div>
</div>
</body>
</html>