<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/reset_password.css" />
</head>

<body>
  <div class="shell">

    <!-- Avatar — sama persis dengan login.php -->
    <div class="avatar">
      <svg viewBox="0 0 24 24">
        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
      </svg>
    </div>

    <?php
    if (isset($_GET['error']))
      echo "<p class='msg error'>" . htmlspecialchars($_GET['error']) . "</p>";
    if (isset($_GET['success']))
      echo "<p class='msg success'>Password berhasil direset. Silakan login.</p>";

    $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
    ?>

    <?php if ($step === 1): ?>

      <!-- Step 1: masukkan username -->
      <p class="form-hint">Masukkan username akunmu untuk mereset password.</p>
      <form class="form" action="../src/feature/login/endpoint/reset_password.php" method="POST">
        <input type="hidden" name="step" value="1" />
        <input type="text" name="username" placeholder="Username" autocomplete="username" required />
        <button type="submit" class="btn-action">Lanjut</button>
      </form>

    <?php elseif ($step === 2): ?>

      <!-- Step 2: isi password baru -->
      <p class="form-hint">Password baru untuk akun <strong><?= htmlspecialchars($_GET['username'] ?? '') ?></strong>.</p>
      <form class="form" action="../src/feature/login/endpoint/reset_password.php" method="POST">
        <input type="hidden" name="step" value="2" />
        <input type="hidden" name="username" value="<?= htmlspecialchars($_GET['username'] ?? '') ?>" />
        <input type="password" name="new_password" placeholder="Password Baru" required minlength="6" />
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required minlength="6" />
        <button type="submit" class="btn-action">Reset Password</button>
      </form>

    <?php endif; ?>

    <p class="bottom-row">Ingat password? <a href="login.php">Login</a></p>

  </div>
</body>

</html>
