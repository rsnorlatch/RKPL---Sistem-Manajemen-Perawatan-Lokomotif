<?php
session_start();
$theme = $_SESSION['theme'] ?? 'day';
require_once __DIR__ . '/../src/db/lms.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$driver_id = (int)$_SESSION['user_id'];
$calls = [];

$stmt = $db->prepare("
    SELECT c.id AS call_id, l.model AS locomotive_model, c.call_time
    FROM calling c
    JOIN accepted_call ac ON ac.call_id = c.id
    JOIN locomotive l ON l.driver_id = c.driver_id
    LEFT JOIN confirmation_finish cf ON cf.calling_id = c.id
    LEFT JOIN confirmation_problem cp ON cp.calling_id = c.id
    WHERE c.driver_id = ?
      AND cf.calling_id IS NULL
      AND cp.calling_id IS NULL
    ORDER BY c.call_time DESC
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $calls[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Panggilan – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling_feature/panggilan.css">
  <link rel="stylesheet" href="../styling_feature/style_dark.css"/>
</head>

<body>
<script>if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');</script>
    <div class="shell">
        <div class="topbar">
            <a href="dashboard_masinis.php" class="back-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
            </a>
            <h1>
                <?php if ($_SESSION["language"] == "id"): ?>
                    Konfirmasi Panggilan
                <?php elseif ($_SESSION["language"] == "en"): ?>
                    Confirmations
                <?php endif; ?>
            </h1>
        </div>
        <div class="page-body">
            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <p class="msg success">
                    <?php if ($_SESSION["language"] == "id"): ?>
                        Konfirmasi berhasil dikirim.
                    <?php elseif ($_SESSION["language"] == "en"): ?>
                        Successfuly sent confirmation.
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <?php if (empty($calls)): ?>
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                    </svg>
                    <p>
                        <?php if ($_SESSION["language"] == "id"): ?>
                            Tidak ada panggilan yang perlu dikonfirmasi
                        <?php elseif ($_SESSION["language"] == "en"): ?>
                            No calls to be confirmed yet
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="call-list">
                    <?php foreach ($calls as $call): ?>
                        <div class="call-item">
                            <span class="call-label">
                                Lokomotif <?= htmlspecialchars($call['locomotive_model']) ?>
                                <small style="display:block; font-weight:400; color:#757575; margin-top:2px;">
                                    <?= date('d M Y, H:i', strtotime($call['call_time'])) ?>
                                </small>
                            </span>
                            <div class="call-actions">
                                <form action="../src/feature/communication/endpoint/confirm_finish.php" method="POST">
                                    <input type="hidden" name="call_id" value="<?= $call['call_id'] ?>">
                                    <button type="submit" class="btn-konfirmasi green">
                                        <?php if ($_SESSION["language"] == "id"): ?>
                                            Selesai
                                        <?php elseif ($_SESSION["language"] == "en"): ?>
                                            Done
                                        <?php endif; ?>
                                    </button>
                                </form>
                                <form action="laporkan_kendala.php" method="POST">
                                    <input type="hidden" name="call_id" value="<?= $call['call_id'] ?>">
                                    <button type="submit" class="btn-konfirmasi">
                                        <?php if ($_SESSION["language"] == "id"): ?>
                                            Terkendala
                                        <?php elseif ($_SESSION["language"] == "en"): ?>
                                            There's issue
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>