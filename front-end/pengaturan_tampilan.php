<!DOCTYPE html>
<?php
use lms\feature\setting\ThemeQuery;
use lms\feature\setting\ThemeVariant;
use lms\feature\setting\GetCurrentLanguageHandler;
use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
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

$theme_query  = new ThemeQuery($preferences, $users);
$themeVariant = $theme_query->get_current_theme($_SESSION["user_id"]);
$theme        = ($themeVariant == ThemeVariant::Light) ? 'day' : 'night';
$_SESSION["theme"] = $theme;

$lang_handler = new GetCurrentLanguageHandler($users, $preferences);
$langVariant  = $lang_handler->handle($_SESSION["user_id"]);
$lang         = ($langVariant->value === 'Indonesia') ? 'id' : 'en';

$ui = $lang === 'en' ? [
  'page_title'  => 'Display',
  'hint'        => 'Choose the application display theme',
  'day_label'   => 'Day',
  'day_hint'    => 'Light',
  'night_label' => 'Night',
  'night_hint'  => 'Dark',
  'saved_ok'    => 'Display theme saved successfully.',
  'saved_err'   => 'An error occurred.',
  'btn_save'    => 'Save',
] : [
  'page_title'  => 'Tampilan',
  'hint'        => 'Pilih tema tampilan aplikasi',
  'day_label'   => 'Day',
  'day_hint'    => 'Terang',
  'night_label' => 'Night',
  'night_hint'  => 'Gelap',
  'saved_ok'    => 'Tampilan berhasil disimpan.',
  'saved_err'   => 'Terjadi kesalahan.',
  'btn_save'    => 'Simpan',
];
?>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tampilan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/pengaturan.css" />

  <!-- FIX 1: Apply dark SEBELUM CSS render, cegah flash putih -->
  <script>if ('<?= $theme ?>' === 'night') document.documentElement.classList.add('dark-init');</script>
  <style>
    /* Prevent flash: sembunyikan body sampai JS siap */
    .dark-init body { background: #121212 !important; }
  </style>
</head>

<body>

  <!-- FIX 2: Apply class dark ke body segera -->
  <script>
    (function() {
      if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');
    })();
  </script>

  <div class="shell">
    <div class="topbar">
      <a href="pengaturan.php" class="back-btn">
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

      <form action="../src/feature/setting/endpoint/save_theme.php" method="POST">
        <div class="radio-list">

          <label class="radio-row <?= $theme === 'day' ? 'active' : '' ?>" data-theme="day">
            <div class="row-icon">
              <svg viewBox="0 0 24 24">
                <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79zM4 10.5H1v2h3zm9-9.95h-2V3.5h2zM18.24 4.84l-1.42 1.41 1.8 1.79 1.41-1.41zM20 10.5v2h3v-2zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41z" />
              </svg>
            </div>
            <input type="radio" name="theme" value="day" <?= $theme === 'day' ? 'checked' : '' ?> />
            <span><?= $ui['day_label'] ?> <span class="hint-text">(<?= $ui['day_hint'] ?>)</span></span>
            <div class="radio-dot"></div>
          </label>

          <label class="radio-row <?= $theme === 'night' ? 'active' : '' ?>" data-theme="night">
            <div class="row-icon">
              <svg viewBox="0 0 24 24">
                <path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c-.44-.06-.9-.1-1.36-.1z" />
              </svg>
            </div>
            <input type="radio" name="theme" value="night" <?= $theme === 'night' ? 'checked' : '' ?> />
            <span><?= $ui['night_label'] ?> <span class="hint-text">(<?= $ui['night_hint'] ?>)</span></span>
            <div class="radio-dot"></div>
          </label>

        </div>
        <button type="submit" class="btn-save"><?= $ui['btn_save'] ?></button>
      </form>
    </div>
  </div>

  <script>
    // FIX 3: Live preview — saat user klik opsi, langsung update tampilan + class active
    document.querySelectorAll('.radio-row').forEach(function(row) {
      row.addEventListener('click', function() {
        var selected = this.dataset.theme; // "day" atau "night"

        // Update class active di radio-row
        document.querySelectorAll('.radio-row').forEach(function(r) {
          r.classList.remove('active');
        });
        this.classList.add('active');

        // Update dark mode body langsung (live preview)
        if (selected === 'night') {
          document.body.classList.add('dark');
        } else {
          document.body.classList.remove('dark');
        }
      });
    });
  </script>

</body>
</html>