<?php
session_start();
require_once __DIR__ . '/../src/db/lms.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$driver_id = (int)$_SESSION['user_id'];
$theme = 'light'; // default

// Ambil tema saat ini
$stmt = $db->prepare("SELECT theme FROM driver_settings WHERE driver_id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $theme = $row['theme'];
}
$stmt->close();

// Proses perubahan tema (jika form dikirim)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $newTheme = ($_POST['theme'] === 'dark') ? 'dark' : 'light';

    // Insert atau update
    $upsert = $db->prepare("
        INSERT INTO driver_settings (driver_id, theme, language) 
        VALUES (?, ?, 'id')
        ON DUPLICATE KEY UPDATE theme = ?
    ");
    $upsert->bind_param("iss", $driver_id, $newTheme, $newTheme);
    $upsert->execute();
    $upsert->close();

    // Redirect untuk menghindari pengiriman ulang form
    header("Location: pengaturan_tampilan.php?status=updated");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Tampilan – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling_feature/pengaturan_tampilan.css">
</head>
<body>
  <?php

  use lms\feature\setting\ThemeQuery;
  use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
  use lms\feature\signup\persistence\MySqlDriverRepository;
  use lms\feature\signup\persistence\MySqlMaintainerRepository;
  use lms\feature\signup\persistence\MySqlCentralOfficeRepository;

  use lms\feature\setting\persistence\RolePreference;
  use lms\feature\setting\ThemeVariant;

  require_once __DIR__ . "/../vendor/autoload.php";

  session_start();
  if (empty($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
  }
  require_once __DIR__ . '/../src/db/lms.php';

  /* // Tentukan tabel settings berdasarkan role */
  /* if (!empty($_SESSION['user_is_driver'])) { */
  /*   $st = 'driver_settings'; */
  /*   $fk = 'driver_id'; */
  /* } elseif (!empty($_SESSION['user_is_maintainer'])) { */
  /*   $st = 'maintainer_settings'; */
  /*   $fk = 'maintainer_id'; */
  /* } else { */
  /*   $st = 'central_office_settings'; */
  /*   $fk = 'central_office_id'; */
  /* } */
  /**/
  /* $uid = (int)$_SESSION['user_id']; */
  /* $res = $db->query("SELECT theme FROM `$st` WHERE `$fk`=$uid LIMIT 1"); */
  /* $theme = ($res && $res->num_rows > 0) ? $res->fetch_assoc()['theme'] : 'day'; */
  if (!empty($_SESSION['user_is_driver']))         $role = 'driver';
  elseif (!empty($_SESSION['user_is_maintainer']))  $role = 'maintainer';
  else                                              $role = 'central_office';

  $preferences = $role == "driver" ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
    : ($role == "maintainer" ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
      : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

  $users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
    : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
      : new MySqlCentralOfficeRepository($db));

  $theme_query = new ThemeQuery($preferences, $users);

  $theme = $theme_query->get_current_theme($_SESSION["user_id"]) == ThemeVariant::Light ? "day" : "night";
  $_SESSION["theme"] = $theme;
  ?>
  <div class="shell">
    <div class="topbar">
      <a href="pengaturan.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1>Tampilan</h1>
    </div>
    <div class="page-body">

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'saved'): ?><p class="msg success">Tampilan berhasil disimpan.</p>
        <?php elseif ($_GET['status'] === 'error'): ?><p class="msg error">Terjadi kesalahan.</p>
        <?php endif; ?>
      <?php endif; ?>

      <p class="section-hint">Pilih tema tampilan aplikasi</p>

      <form action="../src/feature/setting/endpoint/save_theme.php" method="POST">
        <div class="radio-list">

          <label class="radio-row <?= $theme === 'day' ? 'active' : '' ?>">
            <div class="row-icon">
              <svg viewBox="0 0 24 24">
                <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79zM4 10.5H1v2h3zm9-9.95h-2V3.5h2zM18.24 4.84l-1.42 1.41 1.8 1.79 1.41-1.41zM20 10.5v2h3v-2zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41z" />
              </svg>
            </div>
            <input type="radio" name="theme" value="day" <?= $theme === 'day' ? 'checked' : '' ?> />
            <span>Day <span class="hint-text">(Terang)</span></span>
            <div class="radio-dot"></div>
          </label>

          <label class="radio-row <?= $theme === 'night' ? 'active' : '' ?>">
            <div class="row-icon">
              <svg viewBox="0 0 24 24">
                <path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c-.44-.06-.9-.1-1.36-.1z" />
              </svg>
            </div>
            <input type="radio" name="theme" value="night" <?= $theme === 'night' ? 'checked' : '' ?> />
            <span>Night <span class="hint-text">(Gelap)</span></span>
            <div class="radio-dot"></div>
          </label>

    <h2>Pilih Mode Tampilan</h2>
    <form method="POST">
        <div class="theme-option">
            <span> Day Mode</span>
            <input type="radio" name="theme" value="light" <?= ($theme === 'light') ? 'checked' : '' ?>>
        </div>
        <div class="theme-option">
            <span> Night Mode</span>
            <input type="radio" name="theme" value="dark" <?= ($theme === 'dark') ? 'checked' : '' ?>>
        </div>
        <button type="submit" class="btn-save">Simpan</button>
    </form>
</div>
</body>
</html>