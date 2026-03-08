<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Konfirmasi Detail – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/panggilan.css"/>
</head>
<body>
<?php session_start(); ?>

<div class="shell">

  <div class="topbar">
    <a href="konfirmasi.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Konfirmasi</h1>
  </div>

  <div class="page-body">

    <?php
      $call_id = isset($_GET['call_id']) ? (int)$_GET['call_id'] : 0;
      require_once __DIR__ . "/../src/db/lms.php";
      $call = null;
      $result = $db->query("
        SELECT c.*, l.model AS loco_model
        FROM communication c
        LEFT JOIN locomotive l ON c.locomotive_id = l.id
        WHERE c.id = $call_id LIMIT 1
      ");
      if ($result) $call = $result->fetch_assoc();
    ?>

    <?php if (!$call): ?>
      <p class="msg error">Panggilan tidak ditemukan.</p>
    <?php else: ?>

      <!-- Info panggilan -->
      <div class="detail-card">
        <div class="detail-row">
          <span class="detail-key">Lokomotif</span>
          <span class="detail-val"><?= htmlspecialchars($call['loco_model'] ?? '-') ?></span>
        </div>
        <div class="detail-row">
          <span class="detail-key">Pesan</span>
          <span class="detail-val"><?= htmlspecialchars($call['message'] ?? '-') ?></span>
        </div>
      </div>

      <p class="section-hint">Pilih status konfirmasi:</p>

      <!-- Tombol Selesai -->
      <!--
        Kirim ke backend: src/feature/communication/endpoint/confirm_finish.php
        Param POST: call_id
      -->
      <form action="../src/feature/communication/endpoint/confirm_finish.php" method="POST">
        <input type="hidden" name="call_id" value="<?= $call_id ?>"/>
        <button type="submit" class="btn-confirm green-full">
          ✓ &nbsp; Selesai
        </button>
      </form>

      <!-- Tombol Kendala — buka form kendala -->
      <a href="konfirmasi_kendala.php?call_id=<?= $call_id ?>" class="btn-confirm orange-full">
        ⚠ &nbsp; Ada Kendala
      </a>

    <?php endif; ?>
  </div>
</div>

</body>
</html>