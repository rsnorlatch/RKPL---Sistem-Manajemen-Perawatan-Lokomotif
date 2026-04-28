<?php
session_start();
$theme = $_SESSION['theme'] ?? 'day';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kredensial & Keamanan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/pengaturan.css" />
  <link rel="stylesheet" href="../styling_feature/style_dark.css"/>
</head>

<body>
<script>if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');</script>
  <?php
$theme = $_SESSION['theme'] ?? 'day';
  if (empty($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
  }
  ?>
  <div class="shell">
    <div class="topbar">
      <a href="pengaturan.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1>
        <?php if ($_SESSION["language"] == "id"): ?>
          Kredensial &amp; Keamanan
        <?php elseif ($_SESSION["language"] == "en"): ?>
          Credential &amp; Security
        <?php endif; ?>
      </h1>
    </div>
    <div class="page-body">

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'saved'):    ?>
          <p class="msg success">
            <?php if ($_SESSION["language"] == "id"): ?>
              Password berhasil diubah.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Password successfully changed.
            <?php endif; ?>
          </p>
        <?php elseif ($_GET['status'] === 'mismatch'): ?>
          <p class="msg error">
            <?php if ($_SESSION["language"] == "id"): ?>
              Password baru tidak cocok.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Password does not match.
            <?php endif; ?>
          </p>
        <?php elseif ($_GET['status'] === 'wrong'):    ?>
          <p class="msg error">
            <?php if ($_SESSION["language"] == "id"): ?>
              Password lama salah.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Old password incorrect.
            <?php endif; ?>
          </p>
        <?php elseif ($_GET['status'] === 'error'):    ?>
          <p class="msg error">
            <?php if ($_SESSION["language"] == "id"): ?>
              Terjadi kesalahan.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              there is a problem.
            <?php endif; ?>
          </p>
        <?php endif; ?>
      <?php endif; ?>

      <form class="form-card" action="../src/feature/setting/endpoint/save_password.php" method="POST">
        <div class="field-group">
          <label>
            <?php if ($_SESSION["language"] == "id"): ?>
              Password Lama
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Old Password
            <?php endif; ?>
          </label>
          <input type="password" name="old_password" placeholder="<?= $_SESSION["language"] == "id" ? "Password saat ini" : "Current password" ?>" required />
        </div>
        <div class="field-group">
          <label>
            <?php if ($_SESSION["language"] == "id"): ?>
              Password Baru
            <?php elseif ($_SESSION["language"] == "en"): ?>
              New Password
            <?php endif; ?>
          </label>
          <input type="password" name="new_password"
            placeholder="<?= $_SESSION["language"] == "id" ? "minimal 6 karakter" : "At least 6 characters" ?>" required minlength="6" />
        </div>
        <div class="field-group">
          <label>
            <?php if ($_SESSION["language"] == "id"): ?>
              Konfirmasi Password Baru
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Confirm New Password
            <?php endif; ?>
          </label>
          <input type="password" name="confirm_password"
            placeholder="<?= $_SESSION["language"] == "id" ? "Ulangi password baru" : "Repeat new password" ?>" required minlength="6" />
        </div>
        <button type="submit" class="btn-save">
          <?php if ($_SESSION["language"] == "id"): ?>
            Simpan
          <?php elseif ($_SESSION["language"] == "en"): ?>
            Save
          <?php endif; ?>
        </button>
      </form>

    </div>
  </div>
</body>

</html>