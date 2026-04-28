<?php
session_start();
$theme = $_SESSION['theme'] ?? 'day';
require_once __DIR__ . '/../src/db/lms.php';

$notifs = [];
$result = $db->query("SELECT id, message, created_at FROM notification_balaiyasa ORDER BY created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling_feature/notifikasi_balaiyasa.css">
  <link rel="stylesheet" href="../styling_feature/style_dark.css"/>
</head>

<body>
<script>if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');</script>
    <div class="shell">
        <div class="topbar">
            <a href="dashboard_timbalaiyasa.php" class="back-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
            </a>
            <h1><?= $_SESSION["language"] == "id" ? "Notifikasi" : "Notification" ?></h1>
        </div>
        <div class="page-body">
            <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
                <p class="msg success">
                    <?php if ($_SESSION["language"] == "id"): ?>
                        Notifikasi berhasil dihapus.
                    <?php elseif ($_SESSION["language"] == "en"): ?>
                        Successfully deleted notification.
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <?php if (empty($notifs)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.64-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                    </svg>
                    <?php if ($_SESSION["language"] == "id"): ?>
                        <p>Belum ada notifikasi</p>
                    <?php elseif ($_SESSION["language"] == "en"): ?>
                        <p>No notification yet</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="notif-list">
                    <?php foreach ($notifs as $n): ?>
                        <div class="notif-card">
                            <div class="notif-body">
                                <p class="notif-msg"><?= htmlspecialchars($n['message']) ?></p>
                                <span class="notif-time"><?= date('d M Y, H:i', strtotime($n['created_at'])) ?></span>
                            </div>
                            <div class="menu-wrap">
                                <input type="checkbox" id="menu-<?= $n['id'] ?>" class="menu-toggle" />
                                <label for="menu-<?= $n['id'] ?>" class="menu-btn">⋮</label>
                                <div class="dropdown">
                                    <form action="../src/feature/notification/endpoint/delete_notification.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $n['id'] ?>" />
                                        <button type="submit" class="dropdown-item del">
                                            <?= $_SESSION["language"] == "id" ? "Hapus" : "Delete" ?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="trash-wrap">
            <form action="../src/feature/notification/endpoint/delete_all_notification.php" method="POST"
                onsubmit="return confirm(<?= $_SESSION["language"] == "id" ? "Hapus semua notifikasi?" : "Delete all notification?" ?>)">

                <button type=" submit" class="btn-trash" title="Hapus semua notifikasi">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</body>

</html>