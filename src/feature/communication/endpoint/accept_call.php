<?php
namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\CallingResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

global $db;

$call_id = (int)$_POST["call_id"];

$controller = DriverCallingController::create_mysql($db);
$result = $controller->accept_call($call_id);

switch ($result) {
    case CallingResult::Success:
        // Notifikasi ke tabel notification_balaiyasa
        $notif = $db->prepare("INSERT INTO notification_balaiyasa (message) VALUES (?)");
        $msg = "Panggilan ID $call_id diterima oleh masinis.";
        $notif->bind_param("s", $msg);
        $notif->execute();
        $notif->close();

        header("Location: ../../../../front-end/panggilan.php?status=accepted");
        break;

    case CallingResult::CallNotFound:
        header("Location: ../../../../front-end/panggilan.php?status=call_not_found");
        break;
}