<?php
require_once "../vendor/autoload.php";
require_once "../src/db/lms.php";
session_start();

use lms\feature\setting\GetCurrentLanguageHandler;
use lms\feature\setting\LanguageVariant;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\setting\persistence\RolePreference;
use lms\feature\setting\ThemeVariant;
use lms\feature\setting\ThemeQuery;

$username = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'User';

if (!empty($_SESSION['user_is_driver']))        $role = 'driver';
elseif (!empty($_SESSION['user_is_maintainer'])) $role = 'maintainer';
else                                             $role = 'central_office';

$preferences = $role == "driver" ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
  : ($role == "maintainer" ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
    : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

$users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
  : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
    : new MySqlCentralOfficeRepository($db));

$theme    = (new ThemeQuery($preferences, $users))->get_current_theme($_SESSION["user_id"]) == ThemeVariant::Light ? "day" : "night";
$language = (new GetCurrentLanguageHandler($users, $preferences))->handle($_SESSION["user_id"]) == LanguageVariant::Indonesia ? "id" : "en";
$_SESSION["theme"]    = $theme;
$_SESSION["language"] = $language;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Masinis – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/dashboard_masinis.css"/>
  <link rel="stylesheet" href="../styling_feature/style_dark.css"/>
</head>
<body>
<script>if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');</script>

<div class="shell">
  <div class="header">
    <div class="avatar">
      <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
    </div>
    <h1><?= $language == "en" ? "Welcome" : "Selamat datang" ?> <?= $username ?></h1>
  </div>
  <div class="menu-grid">

    <a href="panggilan.php" class="menu-item">
      <div class="menu-icon orange">
        <svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.64-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
      </div>
      <span><?= $language == "en" ? "calls" : "panggilan" ?></span>
    </a>

    <a href="pengaturan.php" class="menu-item">
      <div class="menu-icon orange">
        <svg viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94s-.02-.64-.07-.94l2.03-1.58a.49.49 0 0 0 .12-.61l-1.92-3.32a.49.49 0 0 0-.59-.22l-2.39.96a7.02 7.02 0 0 0-1.62-.94l-.36-2.54A.484.484 0 0 0 14 3h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96a.48.48 0 0 0-.59.22L2.74 8.87a.47.47 0 0 0 .12.61l2.03 1.58c-.05.3-.07.63-.07.94s.02.64.07.94l-2.03 1.58a.47.47 0 0 0-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.37 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.57 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32a.47.47 0 0 0-.12-.61l-2.01-1.58zM12 15.6a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z"/></svg>
      </div>
      <span><?= $language == "en" ? "setting" : "pengaturan" ?></span>
    </a>

    <a href="../src/feature/login/endpoint/logout.php" class="menu-item">
      <div class="menu-icon red">
        <svg viewBox="0 0 24 24"><path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5a2 2 0 0 0-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/></svg>
      </div>
      <span><?= $language == "en" ? "logout" : "keluar" ?></span>
    </a>

    <a href="konfirmasi.php" class="menu-item">
      <div class="menu-icon orange">
        <svg viewBox="0 0 24 24"><path d="M12 2c-4 0-8 .5-8 4v9.5A2.5 2.5 0 0 0 6.5 18l-1.5 1.5v.5h2l2-2h6l2 2h2v-.5L17.5 18a2.5 2.5 0 0 0 2.5-2.5V6c0-3.5-3.58-4-8-4zM7.5 17a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm3.5-7H6V6h5v4zm2 0V6h5v4h-5zm3.5 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>
      </div>
      <span><?= $language == "en" ? "confirmation" : "konfirmasi" ?></span>
    </a>

  </div>
</div>
</body>
</html>