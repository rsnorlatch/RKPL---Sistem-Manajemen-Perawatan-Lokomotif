<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kredensial & Keamanan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/pengaturan.css"/>
</head>
<body>
<?php
session_start();
if (empty($_SESSION['is_logged_in'])) { header('Location: login.php'); exit; }
?>
<div class="shell">
  <div class="topbar">
    <a href="pengaturan.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Kredensial &amp; Keamanan</h1>
  </div>
  <div class="page-body">

    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status']==='saved'):    ?><p class="msg success">Password berhasil diubah.</p>
      <?php elseif ($_GET['status']==='mismatch'): ?><p class="msg error">Password baru tidak cocok.</p>
      <?php elseif ($_GET['status']==='wrong'):    ?><p class="msg error">Password lama salah.</p>
      <?php elseif ($_GET['status']==='error'):    ?><p class="msg error">Terjadi kesalahan.</p>
      <?php endif; ?>
    <?php endif; ?>

    <form class="form-card" action="../src/feature/setting/endpoint/save_password.php" method="POST">
      <div class="field-group">
        <label>Password Lama</label>
        <input type="password" name="old_password" placeholder="Password saat ini" required/>
      </div>
      <div class="field-group">
        <label>Password Baru</label>
        <input type="password" name="new_password" placeholder="Minimal 6 karakter" required minlength="6"/>
      </div>
      <div class="field-group">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password" placeholder="Ulangi password baru" required minlength="6"/>
      </div>
      <button type="submit" class="btn-save">Simpan</button>
    </form>

  </div>
</div>
</body>
</html>