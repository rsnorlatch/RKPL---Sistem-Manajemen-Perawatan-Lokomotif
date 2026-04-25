<?php
namespace lms\feature\sending\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../../db/lms.php";

use lms\feature\sending\SendLocomotiveHandler;
use lms\feature\sending\SendResult;

$locomotive_id  = (int)$_GET['locomotive_id'];
$destination_id = (int)($_GET['destination_id'] ?? 0);
$driver_id      = (int)($_GET['driver_id'] ?? 0);

// Validasi driver jika dipilih
if ($driver_id > 0) {
    $check = $db->prepare("SELECT id FROM driver WHERE id = ?");
    $check->bind_param("i", $driver_id);
    $check->execute();
    if (!$check->get_result()->fetch_assoc()) {
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=driver_not_found");
        exit;
    }
    $check->close();
}

$handler = SendLocomotiveHandler::create_mysql($db);
$result = $handler->handle($locomotive_id, $destination_id);

switch ($result) {
    case SendResult::DestinationNotFound:
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=destination_not_found");
        break;

    case SendResult::LocomotiveNotFound:
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=locomotive_not_found");
        break;

    case SendResult::Success:
        // Update driver_id di locomotive jika diberikan
        if ($driver_id > 0) {
            $upd = $db->prepare("UPDATE locomotive SET driver_id = ? WHERE id = ?");
            if ($upd) {
                $upd->bind_param("ii", $driver_id, $locomotive_id);
                $upd->execute();
                $upd->close();
            }
        } else {
            // fallback: ambil driver_id yang sudah ada di locomotive
            $stmt = $db->prepare("SELECT driver_id FROM locomotive WHERE id = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("i", $locomotive_id);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();
                if ($row) $driver_id = (int)$row['driver_id'];
                $stmt->close();
            }
        }

        // Insert ke tabel calling untuk notifikasi masinis
        if ($driver_id > 0) {
            $ins = $db->prepare("INSERT INTO calling (driver_id, call_time) VALUES (?, NOW())");
            if ($ins) {
                $ins->bind_param("i", $driver_id);
                $ins->execute();
                $ins->close();
            }
        }

        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=locomotive_send_success");
        break;
}
exit;