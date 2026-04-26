<?php
// FILE   : front-end/pengaturan_bahasa.php
// CSS    : styling_feature/pengaturan.css
// BACKEND: src/feature/setting/endpoint/save_language.php
//          src/feature/setting/GetCurrentLanguageHandler.php
//          src/feature/setting/LanguageVariant.php

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

  $handler = new GetCurrentLanguageHandler($users, $preferences);
  $langVariant = $handler->handle($_SESSION["user_id"]);
  // LanguageVariant::Indonesia->value = "Indonesia", ::English->value = "English"
  $lang = ($langVariant->value === 'Indonesia') ? 'id' : 'en';

  // ── Teks UI bilingual ──
  $ui = $lang === 'en' ? [
    'page_title' => 'Language',
    'hint'       => 'Select application language',
    'saved_ok'   => 'Language saved successfully.',
    'saved_err'  => 'An error occurred.',
    'btn_save'   => 'Save',
  ] : [
    'page_title' => 'Bahasa',
    'hint'       => 'Pilih bahasa aplikasi',
    'saved_ok'   => 'Bahasa berhasil disimpan.',
    'saved_err'  => 'Terjadi kesalahan.',
    'btn_save'   => 'Simpan',
  ];
  ?>

  <div class="shell">
    <div class="topbar">
      <a href="./pengaturan.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1><?= htmlspecialchars($ui['page_title']) ?></h1>
    </div>
    <div class="page-body">

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'saved'): ?>
          <p class="msg success"><?= $ui['saved_ok'] ?></p>
        <?php elseif ($_GET['status'] === 'error'): ?>
          <p class="msg error"><?= $ui['saved_err'] ?></p>
        <?php endif; ?>
      <?php endif; ?>

      <p class="section-hint"><?= $ui['hint'] ?></p>

      <form action="../src/feature/setting/endpoint/save_language.php" method="POST">
        <div class="radio-list">

          <label class="radio-row <?= $lang === 'id' ? 'active' : '' ?>">
            <span>Indonesia</span>
            <input type="radio" name="lang" value="id" <?= $lang === 'id' ? 'checked' : '' ?> />
            <div class="radio-dot"></div>
          </label>

          <label class="radio-row <?= $lang === 'en' ? 'active' : '' ?>">
            <span>English</span>
            <input type="radio" name="lang" value="en" <?= $lang === 'en' ? 'checked' : '' ?> />
            <div class="radio-dot"></div>
          </label>

        </div>
        <button type="submit" class="btn-save"><?= $ui['btn_save'] ?></button>
      </form>

    </div>
  </div>
</body>

</html>
