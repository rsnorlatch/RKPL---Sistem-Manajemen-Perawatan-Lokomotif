<?php



?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Konfirmasi – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/panggilan.css" />
</head>

<body>
  <?php session_start(); ?>

  <div class="shell">

    <div class="topbar">
      <a href="dashboard_masinis.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1>Konfirmasi</h1>
    </div>

    <div class="page-body">

      <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'done'): ?>
          <p class="msg success">Konfirmasi selesai berhasil dikirim.</p>
        <?php elseif ($_GET['status'] === 'kendala'): ?>
          <p class="msg success">Laporan kendala berhasil dikirim.</p>
        <?php endif; ?>
      <?php endif; ?>

      <?php
      // Ambil panggilan yang sudah diterima (accepted) oleh masinis ini
      $calls = [];
      require_once __DIR__ . "/../src/db/lms.php";
      $result = $db->query("
        SELECT
          l.model AS loco_model,
          a.call_id AS id
           
        FROM accepted_call a
        JOIN calling c ON a.call_id = c.id
        JOIN locomotive l ON c.driver_id = l.driver_id
        WHERE l.driver_id = 1
        ORDER BY c.call_time DESC;
      ");

      if ($result) {
        while ($row = $result->fetch_assoc()) $calls[] = $row;
      }
      ?>

      <?php if (empty($calls)): ?>
        <div class="empty-state">
          <svg viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
          </svg>
          <p>Belum ada panggilan yang diterima</p>
        </div>

      <?php else: ?>
        <div class="call-list">
          <?php foreach ($calls as $call): ?>
            <div class="call-item">
              <span class="call-label">
                Kirim Lokomotif ke <?= htmlspecialchars($call['loco_model'] ?? '-') ?>
              </span>
              <!-- Tombol konfirmasi → buka halaman detail konfirmasi -->
              <a href="konfirmasi_detail.php?call_id=<?= $call['id'] ?>" class="btn-konfirmasi">
                konfirmasi
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>

</body>

</html>
