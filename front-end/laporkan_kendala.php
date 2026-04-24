<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$call_id = isset($_POST['call_id']) ? (int)$_POST['call_id'] : 0;
if ($call_id === 0) {
    header("Location: konfirmasi.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Kendala – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling_feature/panggilan.css">
</head>
<body>
<div class="shell">
    <div class="topbar">
        <a href="konfirmasi.php" class="back-btn">
            <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
        </a>
        <h1>Lapor Kendala</h1>
    </div>
    <div class="page-body page-body--tolak">
        <div>
            <label class="tolak-label">Detail Kendala</label>
            <textarea name="problem" class="tolak-area" placeholder="Tulis kendala yang dihadapi..." form="form-kendala" required></textarea>
        </div>
        <form id="form-kendala" action="../src/feature/communication/endpoint/confirm_problem.php" method="POST">
            <input type="hidden" name="call_id" value="<?= $call_id ?>">
            <button type="submit" class="btn-tolak">Kirim Laporan</button>
        </form>
    </div>
</div>
</body>
</html>