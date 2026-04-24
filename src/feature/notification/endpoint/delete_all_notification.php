<?php
session_start();
require_once __DIR__ . '/../../../db/lms.php';

$db->query("DELETE FROM notification_balaiyasa");

header("Location: ../../../../front-end/notifikasi_balaiyasa.php?status=deleted");
exit;