<?php
session_start();
require_once __DIR__ . '/../src/db/lms.php';

$calls = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $db->prepare("
        SELECT
            c.id,
            c.driver_id,
            l.model
        FROM calling c
        JOIN locomotive l ON l.driver_id = c.driver_id
        LEFT JOIN accepted_call ac ON ac.call_id = c.id
        LEFT JOIN rejected_call rc ON rc.call_id = c.id
        WHERE c.driver_id = ?
          AND ac.call_id IS NULL
          AND rc.call_id IS NULL
    ");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $calls[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notifikasi – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../styling_feature/panggilan.css" />
</head>
<body>
    <div class="shell">
        <div class="topbar">
            <a href="dashboard_masinis.php" class="back-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
            </a>
            <h1>Notifikasi</h1>
        </div>

        <div class="page-body">
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] === 'accepted'): ?>
                    <p class="msg success">Panggilan berhasil diterima.</p>
                <?php elseif ($_GET['status'] === 'rejected'): ?>
                    <p class="msg success">Alasan penolakan berhasil dikirim.</p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (empty($calls)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.64-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                    </svg>
                    <p>Belum ada panggilan</p>
                </div>
            <?php else: ?>
                <div class="call-list">
                    <?php foreach ($calls as $call): ?>
                        <div class="call-item">
                            <span class="call-label">
                                Panggilan ke Balai Yasa untuk lokomotif <?= htmlspecialchars($call['model']) ?> (ID: <?= $call['id'] ?>)
                            </span>
                            <div class="call-actions">
                                <form action="../src/feature/communication/endpoint/accept_call.php" method="POST">
                                    <input type="hidden" name="call_id" value="<?= $call['id'] ?>" />
                                    <button type="submit" class="btn-circle green" title="Terima">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                        </svg>
                                    </button>
                                </form>
                                <a href="tolak_panggilan.php?call_id=<?= $call['id'] ?>" class="btn-circle red" title="Tolak">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>