<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jadwal Perawatan – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styling_feature/jadwal.css" />
</head>

<body>

  <div class="shell">

    <div class="topbar">
      <a href="dashboard_balai_yasa.php" class="back-btn">
        <svg viewBox="0 0 24 24">
          <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
        </svg>
      </a>
      <h1>Jadwal Perawatan</h1>
    </div>

    <div class="page-body">
      <?php
      require_once __DIR__ . "/../src/db/lms.php";
      $locos  = [];
      $result = $db->query("SELECT id, model FROM locomotive ORDER BY id");
      if ($result) {
        while ($row = $result->fetch_assoc()) $locos[] = $row;
      }

      if (empty($locos)):
      ?>
        <div class="empty-state">
          <svg viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
          </svg>
          <p>Belum ada data lokomotif.</p>
        </div>
      <?php else: ?>

        <div class="loco-list">
          <?php foreach ($locos as $i => $loco):
            // Nama display: "Lokomotif A/B/C..." berurutan
            $letter = chr(65 + $i); // A, B, C, ...
            $label  = 'Lokomotif ' . $letter;
            $code   = 'LK-' . $loco['id'];
          ?>
            <div class="loco-card" style="animation-delay: <?= $i * 0.06 ?>s">
              <div class="loco-info">
                <div class="loco-name"><?= htmlspecialchars($label) ?></div>
                <div class="loco-code"><?= htmlspecialchars($loco['model'] ?? $code) ?></div>
              </div>
              <a class="btn-atur"
                href="atur_jadwal.php?loco_id=<?= $loco['id'] ?>&model=<?= urlencode($label) ?>&kode=<?= urlencode($code) ?>">
                Atur
              </a>
            </div>
          <?php endforeach; ?>
        </div>

      <?php endif; ?>
    </div>
  </div>

</body>

</html>
