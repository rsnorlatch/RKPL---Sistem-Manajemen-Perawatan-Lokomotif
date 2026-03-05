<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login – LMS PT KAI</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" />
  <link rel="stylesheet" href="/styling_feature/login.css"/>
</head>
<body>
<div class="shell">

  <div class="avatar">
    <svg viewBox="0 0 24 24">
      <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
    </svg>
  </div>

  <?php
    // Tampilkan pesan dari redirect backend
    if (isset($_GET['error'])) {
      $err = htmlspecialchars($_GET['error']);
      echo "<p class='msg error'>$err</p>";
    }
    if (isset($_GET['success'])) {
      echo "<p class='msg success'>Registrasi berhasil! Silakan login.</p>";
    }
  ?> 
  
  <form class="form" action="../src/feature/login/endpoint/login.php" method="POST">
    <input type="text"     name="username" placeholder="Username" autocomplete="username" required/>
    <input type="password" name="password" placeholder="Password" autocomplete="current-password" required/>
    <a href="reset_password.php" class="link-reset">Reset Password</a>
    <button type="submit" class="btn-login">Login</button>
  </form>

  <p class="register-row">
    Belum punya akun? <a href="sign_up.php">Registrasi</a>
  </p>

</div>
</body>
</html>