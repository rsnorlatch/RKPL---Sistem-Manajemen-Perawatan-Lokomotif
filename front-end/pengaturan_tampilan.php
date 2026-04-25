<?php
session_start();
require_once __DIR__ . '/../src/db/lms.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$driver_id = (int)$_SESSION['user_id'];
$theme = 'light'; // default

// Ambil tema saat ini
$stmt = $db->prepare("SELECT theme FROM driver_settings WHERE driver_id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $theme = $row['theme'];
}
$stmt->close();

// Proses perubahan tema (jika form dikirim)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $newTheme = ($_POST['theme'] === 'dark') ? 'dark' : 'light';

    // Insert atau update
    $upsert = $db->prepare("
        INSERT INTO driver_settings (driver_id, theme, language) 
        VALUES (?, ?, 'id')
        ON DUPLICATE KEY UPDATE theme = ?
    ");
    $upsert->bind_param("iss", $driver_id, $newTheme, $newTheme);
    $upsert->execute();
    $upsert->close();

    // Redirect untuk menghindari pengiriman ulang form
    header("Location: pengaturan_tampilan.php?status=updated");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Tampilan – LMS PT KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styling_feature/pengaturan_tampilan.css">
</head>
<body>
<div class="container">
    <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
        <div class="msg success">Pengaturan tampilan diperbarui.</div>
    <?php endif; ?>

    <h2>Pilih Mode Tampilan</h2>
    <form method="POST">
        <div class="theme-option">
            <span> Day Mode</span>
            <input type="radio" name="theme" value="light" <?= ($theme === 'light') ? 'checked' : '' ?>>
        </div>
        <div class="theme-option">
            <span> Night Mode</span>
            <input type="radio" name="theme" value="dark" <?= ($theme === 'dark') ? 'checked' : '' ?>>
        </div>
        <button type="submit" class="btn-save">Simpan</button>
    </form>
</div>
</body>
</html>