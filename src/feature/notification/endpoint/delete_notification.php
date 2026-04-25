<!-- Menghapus beberapa notifikasi tertentu Balai Yasa -->
<?php
session_start();
require_once __DIR__ . '/../../../db/lms.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $stmt = $db->prepare("DELETE FROM notification_balaiyasa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
header("Location: ../../../../front-end/notifikasi_balaiyasa.php?status=deleted");
exit;