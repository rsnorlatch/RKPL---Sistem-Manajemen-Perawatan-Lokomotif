<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifikasi – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/panggilan.css"/>
</head>
<body>
<?php session_start(); ?>

<div class="shell">

  <div class="topbar">
    <a href="panggilan.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Notifikasi</h1>
  </div>

  <div class="page-body page-body--tolak">

    <?php $call_id = isset($_GET['call_id']) ? (int)$_GET['call_id'] : 0; ?>

    <p class="tolak-label">Tuliskan alasan penolakkan</p>

    <!--
      Kirim ke backend: src/feature/communication/endpoint/reject_call.php
      Param POST: call_id, reason
    -->
    <form action="../src/feature/communication/endpoint/reject_call.php" method="POST">
      <input type="hidden" name="call_id" value="<?= $call_id ?>"/>
      <textarea name="reason" class="tolak-area" placeholder="Tulis alasan di sini..." required></textarea>
      <button type="submit" class="btn-tolak">Tolak</button>
    </form>

  </div>
</div>

</body>
</html>
