<?php
session_start();
$theme = $_SESSION['theme'] ?? 'day';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Atur Profil – LMS PT KAI</title>
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
  require_once __DIR__ . '/../src/db/lms.php';

  // Tentukan tabel berdasarkan flag session LoginHandler
  if (!empty($_SESSION['user_is_driver']))         $table = 'driver';
  elseif (!empty($_SESSION['user_is_maintainer']))  $table = 'maintainer';
  else                                              $table = 'central_office';

  $uid  = (int)$_SESSION['user_id'];
  $res  = $db->query("SELECT username FROM `$table` WHERE id=$uid LIMIT 1");
  $nama = ($res && $res->num_rows > 0) ? $res->fetch_assoc()['username'] : '';
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
          Atur Profil
        <?php elseif ($_SESSION["language"] == "en"): ?>
          Configure Profile
        <?php endif; ?>
      </h1>
    </div>
    <div class="page-body">

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'saved'): ?><p class="msg success">
            <?php if ($_SESSION["language"] == "id"): ?>
              Nama berhasil disimpan.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Successfully saved new username
            <?php endif; ?>
          </p>
        <?php elseif ($_GET['status'] === 'error'): ?><p class="msg error">
            <?php if ($_SESSION["language"] == "id"): ?>
              Terjadi kesalahan.
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Problem occured
            <?php endif; ?>
          </p>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Profil: hanya nama saja -->
      <form class="form-card" action="../src/feature/setting/endpoint/save_profile.php" method="POST">
        <div class="field-group">
          <label>
            <?php if ($_SESSION["language"] == "id"): ?>
              Nama
            <?php elseif ($_SESSION["language"] == "en"): ?>
              Username
            <?php endif; ?>
          </label>
          <input type="text" name="nama"
            value="<?= htmlspecialchars($nama) ?>"
            placeholder="Masukkan nama" required />
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