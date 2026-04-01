<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bahasa – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/pengaturan.css"/>
</head>
<body>
<?php
session_start();
if (empty($_SESSION['is_logged_in'])) { header('Location: login.php'); exit; }
require_once __DIR__ . '/../src/db/lms.php';

if (!empty($_SESSION['user_is_driver']))         $role = 'driver';
elseif (!empty($_SESSION['user_is_maintainer']))  $role = 'maintainer';
else                                              $role = 'central_office';

$uid   = (int)$_SESSION['user_id'];
$r_esc = $db->real_escape_string($role);
$res   = $db->query("SELECT language FROM user_settings WHERE user_id=$uid AND user_role='$r_esc' LIMIT 1");
$lang  = ($res && $res->num_rows > 0) ? $res->fetch_assoc()['language'] : ($_SESSION['lang'] ?? 'id');
$_SESSION['lang'] = $lang;
?>
<div class="shell">
  <div class="topbar">
    <a href="pengaturan.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Bahasa</h1>
  </div>
  <div class="page-body">

    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status']==='saved'): ?><p class="msg success">Bahasa berhasil disimpan.</p>
      <?php elseif ($_GET['status']==='error'): ?><p class="msg error">Terjadi kesalahan.</p>
      <?php endif; ?>
    <?php endif; ?>

    <p class="section-hint">Pilih bahasa aplikasi</p>

    <form action="../src/feature/setting/endpoint/save_language.php" method="POST">
      <div class="radio-list">

        <label class="radio-row <?= $lang==='id' ? 'active' : '' ?>">
          <span class="flag">🇮🇩</span>
          <span>Indonesia</span>
          <input type="radio" name="lang" value="id" <?= $lang==='id' ? 'checked' : '' ?>/>
          <div class="radio-dot"></div>
        </label>

        <label class="radio-row <?= $lang==='en' ? 'active' : '' ?>">
          <span class="flag">🇬🇧</span>
          <span>English</span>
          <input type="radio" name="lang" value="en" <?= $lang==='en' ? 'checked' : '' ?>/>
          <div class="radio-dot"></div>
        </label>

      </div>
      <button type="submit" class="btn-save">Simpan</button>
    </form>

  </div>
</div>
</body>
</html>