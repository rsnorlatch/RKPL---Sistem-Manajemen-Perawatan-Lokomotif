 <?php
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Pragma: no-cache");
  header("Expires: 0");
  session_start();
$theme = $_SESSION['theme'] ?? 'day';

  $back_link = isset($_SESSION["user_is_driver"]) ? "dashboard_masinis.php"
    : (isset($_SESSION["user_is_maintainer"]) ? "dashboard_timbalaiyasa.php"
      : "dashboard_kantorpusat.php");
  ?>

<!DOCTYPE html>
<html lang="id">
 
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengaturan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/pengaturan.css" />
  <link rel="stylesheet" href="../styling_feature/style_dark.css"/>
</head>
 
<body>
<script>if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');</script>
  <div class="shell">
 
    <!-- Top Bar -->
 
    <div class="topbar">
      <a href="<?= $back_link ?>" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <div class="topbar-icon">
        <svg viewBox="0 0 24 24">
          <path d="M19.14 12.94c.04-.3.06-.61.06-.94s-.02-.64-.07-.94l2.03-1.58a.49.49 0 0 0 .12-.61l-1.92-3.32a.49.49 0 0 0-.59-.22l-2.39.96a7.02 7.02 0 0 0-1.62-.94l-.36-2.54A.484.484 0 0 0 14 3h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96a.48.48 0 0 0-.59.22L2.74 8.87a.47.47 0 0 0 .12.61l2.03 1.58c-.05.3-.07.63-.07.94s.02.64.07.94l-2.03 1.58a.47.47 0 0 0-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.37 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.57 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32a.47.47 0 0 0-.12-.61l-2.01-1.58zM12 15.6a3.6 3.6 0 1 1 0-7.2 3.6 3.6 0 0 1 0 7.2z" />
        </svg>
      </div>
      <h1>
        <?php if ($_SESSION["language"] == "id"): ?>
          Pengaturan
        <?php elseif ($_SESSION["language"] == "en"): ?>
          Setting
        <?php endif; ?>
      </h1>
    </div>
 
    <div class="page-body">
 
      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'saved'): ?>
          <p class="msg success">
            <?php if ($_SESSION["language"] == "id"): ?>
              Pengaturan berhasil disimpan.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Setting saved successfully.
            <?php endif; ?>
          </p>
        <?php elseif ($_GET['status'] === 'error'): ?>
          <p class="msg error">
            <?php if ($_SESSION["language"] == "id"): ?>
              Terjadi kesalahan.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              There is a problem.
            <?php endif; ?>
          </p>
        <?php endif; ?>
      <?php endif; ?>
 
      <div class="menu-list">
 
        <!-- Atur Profil -->
        <a href="pengaturan_profil.php" class="menu-row">
          <div class="row-icon">
            <svg viewBox="0 0 24 24">
              <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
            </svg>
          </div>
          <span>
            <?php if ($_SESSION["language"] == "id"): ?>
              Atur profil
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Configure profile
            <?php endif; ?>
          </span>
          <div class="row-arrow">
            <svg viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
            </svg>
          </div>
        </a>
 
        <!-- Kredensial & Keamanan -->
        <a href="pengaturan_kredensial.php" class="menu-row">
          <div class="row-icon">
            <svg viewBox="0 0 24 24">
              <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93C9.33 17.79 7 14.5 7 11V7.18L12 5z" />
            </svg>
          </div>
          <span>
            <?php if ($_SESSION["language"] == "id"): ?>
              Kredensial &amp; Keamanan
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Credentials &amp; Security
            <?php endif; ?>
          </span>
          <div class="row-arrow">
            <svg viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
            </svg>
          </div>
        </a>
 
        <!-- Tampilan -->
        <a href="pengaturan_tampilan.php" class="menu-row">
          <div class="row-icon">
            <svg viewBox="0 0 24 24">
              <path d="M12 3a9 9 0 1 0 0 18A9 9 0 0 0 12 3zm-1 13.93V17a1 1 0 0 1 2 0v-.07A7.002 7.002 0 0 0 19 11h-.5a.5.5 0 0 1 0-1H19a7.002 7.002 0 0 0-6-6.93V3.5a.5.5 0 0 1-1 0v-.43A7.002 7.002 0 0 0 5 9h.5a.5.5 0 0 1 0 1H5a7.002 7.002 0 0 0 6 6.93zM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8z" />
            </svg>
          </div>
          <span>
            <?php if ($_SESSION["language"] == "id"): ?>
              Tampilan
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Display
            <?php endif; ?>
          </span>
          <div class="row-arrow">
            <svg viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
            </svg>
          </div>
        </a>
 
        <!-- Bahasa -->
        <a href="pengaturan_bahasa.php" class="menu-row">
          <div class="row-icon">
            <svg viewBox="0 0 24 24">
              <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 0 0-1.38-3.56A8.03 8.03 0 0 1 18.92 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2s.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.987 7.987 0 0 1 5.08 16zm2.95-8H5.08a7.987 7.987 0 0 1 4.33-3.56A15.65 15.65 0 0 0 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2s.07-1.35.16-2h4.68c.09.65.16 1.32.16 2s-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 0 1-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2s-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z" />
            </svg>
          </div>
          <span>
            <?php if ($_SESSION["language"] == "id"): ?>
              Bahasa
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Language
            <?php endif; ?>
          </span>
          <div class="row-arrow">
            <svg viewBox="0 0 24 24">
              <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
            </svg>
          </div>
        </a>
 
      </div>
    </div>
  </div>
 
</body>
 
</html>
 