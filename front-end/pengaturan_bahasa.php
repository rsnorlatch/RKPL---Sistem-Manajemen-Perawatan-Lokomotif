<?php
/* header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); */
/* header("Pragma: no-cache"); */
/* header("Expires: 0"); */
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bahasa – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/pengaturan.css" />
</head>

<body>
  <?php

  use lms\feature\setting\GetCurrentLanguageHandler;
  use lms\feature\signup\persistence\MySqlDriverRepository;
  use lms\feature\signup\persistence\MySqlMaintainerRepository;
  use lms\feature\signup\persistence\MySqlCentralOfficeRepository;

  use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
  use lms\feature\setting\persistence\RolePreference;

  require_once __DIR__ . "/../vendor/autoload.php";

  session_start();
  if (empty($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
  }
  require_once __DIR__ . '/../src/db/lms.php';

  if (!empty($_SESSION['user_is_driver']))         $role = 'driver';
  elseif (!empty($_SESSION['user_is_maintainer']))  $role = 'maintainer';
  else                                              $role = 'central_office';

  $preferences = $role == "driver" ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
    : ($role == "maintainer" ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
      : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

  $users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
    : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
      : new MySqlCentralOfficeRepository($db));

  $handler =  new GetCurrentLanguageHandler($users, $preferences);
  $lang = $handler->handle($_SESSION["user_id"]);
  ?>

  <div class="shell">
    <div class="topbar">
      <a href="./pengaturan.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1>Bahasa</h1>
    </div>
    <div class="page-body">

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'saved'): ?><p class="msg success">Bahasa berhasil disimpan.</p>
        <?php elseif ($_GET['status'] === 'error'): ?><p class="msg error">Terjadi kesalahan.</p>
        <?php endif; ?>
      <?php endif; ?>

      <p class="section-hint">Pilih bahasa aplikasi</p>

      <form action="../src/feature/setting/endpoint/save_language.php" method="POST">
        <div class="radio-list">

          <label class="radio-row <?= $lang === 'id' ? 'active' : '' ?>">
            <span class="flag">🇮🇩</span>
            <span>Indonesia</span>
            <input type="radio" name="lang" value="id" <?= $lang === 'id' ? 'checked' : '' ?> />
            <div class="radio-dot"></div>
          </label>

          <label class="radio-row <?= $lang === 'en' ? 'active' : '' ?>">
            <span class="flag">🇬🇧</span>
            <span>English</span>
            <input type="radio" name="lang" value="en" <?= $lang === 'en' ? 'checked' : '' ?> />
            <div class="radio-dot"></div>
          </label>

        </div>
        <button type="submit" class="btn-save">Simpan</button>
      </form>

    </div>
  </div>
</body>

</html>
