<?php
session_start();
require_once __DIR__ . '/../../../db/lms.php';

if (!isset($_POST['call_id'])) {
    header("Location: ../../../../front-end/konfirmasi.php?status=error");
    exit;
}

$call_id   = (int)$_POST['call_id'];
$driver_id = (int)($_SESSION['user_id'] ?? 0);

$check = $db->prepare("
    SELECT 1 FROM calling c
    JOIN accepted_call ac ON ac.call_id = c.id
    WHERE c.id = ? AND c.driver_id = ?
");
$check->bind_param("ii", $call_id, $driver_id);
$check->execute();
$check->store_result();
if ($check->num_rows === 0) {
    header("Location: ../../../../front-end/konfirmasi.php?status=error");
    exit;
}
$check->close();

$stmt = $db->prepare("INSERT INTO confirmation_finish (driver_id, calling_id) VALUES (?, ?)");
$stmt->bind_param("ii", $driver_id, $call_id);
$stmt->execute();
$stmt->close();

$notif = $db->prepare("INSERT INTO notification_balaiyasa (message) VALUES (?)");
$msg = "Lokomotif untuk panggilan ID $call_id telah sampai (konfirmasi selesai).";
$notif->bind_param("s", $msg);
$notif->execute();
$notif->close();

header("Location: ../../../../front-end/konfirmasi.php?status=success");
exit;