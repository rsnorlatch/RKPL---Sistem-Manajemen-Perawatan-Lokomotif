<?php
session_start();
$theme = $_SESSION['theme'] ?? 'day';
require_once __DIR__ . '/../src/db/lms.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$call_id = isset($_REQUEST['call_id']) ? (int)$_REQUEST['call_id'] : 0;
if ($call_id === 0) {
    header("Location: panggilan.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reason    = trim($_POST['reason'] ?? '');
    $driver_id = (int)$_SESSION['user_id'];

    if (empty($reason)) {
        header("Location: tolak_panggilan.php?call_id=$call_id&status=empty_reason");
        exit;
    }

    $check = $db->prepare("SELECT id FROM calling WHERE id = ? AND driver_id = ?");
    $check->bind_param("ii", $call_id, $driver_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) {
        header("Location: panggilan.php?status=error");
        exit;
    }
    $check->close();

    $ins = $db->prepare("INSERT INTO rejected_call (call_id, reason) VALUES (?, ?)");
    $ins->bind_param("is", $call_id, $reason);
    $ins->execute();
    $ins->close();

    $notif = $db->prepare("INSERT INTO notification_balaiyasa (message) VALUES (?)");
    $msg = "Panggilan ID $call_id ditolak. Alasan: $reason";
    $notif->bind_param("s", $msg);
    $notif->execute();
    $notif->close();

    header("Location: panggilan.php?status=rejected");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tolak Panggilan – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling_feature/panggilan.css">
    <link rel="stylesheet" href="../styling_feature/style_dark.css" />
</head>

<body>
    <script>
        if ('<?= $theme ?>' === 'night') document.body.classList.add('dark');
    </script>
    <div class="shell">
        <div class="topbar">
            <a href="panggilan.php" class="back-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                </svg>
            </a>
            <h1>Tolak Panggilan</h1>
        </div>
        <div class="page-body page-body--tolak">
            <?php if (isset($_GET['status']) && $_GET['status'] === 'empty_reason'): ?>
                <p class="msg error">Alasan penolakan tidak boleh kosong.</p>
            <?php endif; ?>
            <div>
                <label class="tolak-label">Tuliskan alasan penolakan</label>
                <textarea name="reason" class="tolak-area" placeholder="Tulis kendala yang dihadapi..." form="form-kendala" required></textarea>
            </div>
            <form id="form-kendala" action="../src/feature/communication/endpoint/reject_call.php" method="POST">
                <input type="hidden" name="call_id" value="<?= $call_id ?>">
                <button type="submit" class="btn-tolak">Tolak</button>
            </form>
        </div>
    </div>
</body>

</html>
