<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/dashboard_kantorpusat.css" />
</head>

<body>

  <?php


  require_once "../vendor/autoload.php";
  require_once "../src/db/lms.php";

  session_start();
  $username = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'User';

  use lms\feature\setting\GetCurrentLanguageHandler;
  use lms\feature\setting\LanguageVariant;
  use lms\feature\signup\persistence\MySqlDriverRepository;
  use lms\feature\signup\persistence\MySqlMaintainerRepository;
  use lms\feature\signup\persistence\MySqlCentralOfficeRepository;

  use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
  use lms\feature\setting\persistence\RolePreference;
  use lms\feature\setting\ThemeVariant;
  use lms\feature\setting\ThemeQuery;

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
  $language_query =  new GetCurrentLanguageHandler($users, $preferences);

  $theme = $theme_query->get_current_theme($_SESSION["user_id"]) == ThemeVariant::Light ? "day" : "night";
  $lang = $language_query->handle($_SESSION["user_id"]) == LanguageVariant::Indonesia ? "id" : "en";

  $_SESSION["lang"] = $lang;
  $_SESSION["theme"] = $theme;
  ?>

  <div class="shell">

    <!-- Header biru: avatar + welcome -->
    <div class="header">
      <div class="avatar">
        <svg viewBox="0 0 24 24">
          <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
        </svg>
      </div>
      <h1>Welcome <?= $username ?></h1>
    </div>

    <!-- Grid menu -->
    <div class="menu-grid">

      <!-- Atur Program Perawatan -->
      <a href="atur_program.php" class="menu-item">
        <div class="menu-icon orange">
          <!-- icon dokumen/list -->
          <svg viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 13h8v1.5H8V13zm0 3h8v1.5H8V16zm0-6h4v1.5H8V10z" />
          </svg>
        </div>
        <span>atur program perawatan</span>
      </a>

      <!-- Pengaturan -->
      <a href="pengaturan.php" class="menu-item">
        <div class="menu-icon orange">
          <!-- icon gear/settings -->
          <svg viewBox="0 0 24 24">
            <path d="M19.14 12.94c.04-.3.06-.61.06-.94s-.02-.64-.07-.94l2.03-1.58a.49.49 0 0 0 .12-.61l-1.92-3.32a.49.49 0 0 0-.59-.22l-2.39.96a7.02 7.02 0 0 0-1.62-.94l-.36-2.54a.484.484 0 0 0-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96a.48.48 0 0 0-.59.22L2.74 8.87a.47.47 0 0 0 .12.61l2.03 1.58c-.05.3-.07.63-.07.94s.02.64.07.94l-2.03 1.58a.47.47 0 0 0-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.37 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.57 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32a.47.47 0 0 0-.12-.61l-2.01-1.58zM12 15.6a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z" />
          </svg>
        </div>
        <span>pengaturan</span>
      </a>

      <!-- Logout -->
      <a href="../src/feature/login/endpoint/logout.php" class="menu-item">
        <div class="menu-icon red">
          <!-- icon logout/arrow-right-from-box -->
          <svg viewBox="0 0 24 24">
            <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5a2 2 0 0 0-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z" />
          </svg>
        </div>
        <span>logout</span>
      </a>

    </div>
  </div>

</body>

</html>
