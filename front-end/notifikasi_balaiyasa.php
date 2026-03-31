<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifikasi – LMS PT KAI</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../styling_feature/notifikasi_balaiyasa.css"/>
</head>
<body>
<?php session_start(); ?>

<div class="shell">

  <div class="topbar">
    <a href="dashboard_timbalaiyasa.php" class="back-btn">
      <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
    </a>
    <h1>Notifikasi</h1>
  </div>

  <div class="page-body">

    <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
      <p class="msg success">Notifikasi berhasil dihapus.</p>
    <?php endif; ?>

    <?php
      // Ambil notifikasi dari DB
      // Tabel: notification (id, message, created_at) — belum ada, sementara empty state
      $notifs = [];

      // TODO: uncomment setelah tabel notification dibuat
      // require_once __DIR__ . "/../src/db/lms.php";
      // $result = $db->query("SELECT * FROM notification ORDER BY created_at DESC");
      // if ($result) {
      //   while ($row = $result->fetch_assoc()) $notifs[] = $row;
      // }
    ?>

    <?php if (empty($notifs)): ?>
      <div class="empty-state">
        <svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.64-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
        <p>Belum ada notifikasi</p>
      </div>

    <?php else: ?>
      <div class="notif-list">
        <?php foreach ($notifs as $n): ?>
          <div class="notif-card">
            <div class="notif-body">
              <p class="notif-msg"><?= htmlspecialchars($n['message']) ?></p>
              <span class="notif-time"><?= date('d M Y, H:i', strtotime($n['created_at'])) ?></span>
            </div>
            <!-- Titik tiga — menu delete -->
            <div class="menu-wrap">
              <input type="checkbox" id="menu-<?= $n['id'] ?>" class="menu-toggle"/>
              <label for="menu-<?= $n['id'] ?>" class="menu-btn">⋮</label>
              <div class="dropdown">
                <form action="../src/feature/notification/endpoint/delete_notification.php" method="POST">
                  <input type="hidden" name="id" value="<?= $n['id'] ?>"/>
                  <button type="submit" class="dropdown-item del">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>

  <!-- Tombol trashbin merah di tengah bawah -->
  <div class="trash-wrap">
    <form action="../src/feature/notification/endpoint/delete_all_notification.php" method="POST"
          onsubmit="return confirm('Hapus semua notifikasi?')">
      <button type="submit" class="btn-trash" title="Hapus semua notifikasi">
        <svg viewBox="0 0 24 24">
          <path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
        </svg>
      </button>
    </form>
  </div>

</div>

</body>
</html>