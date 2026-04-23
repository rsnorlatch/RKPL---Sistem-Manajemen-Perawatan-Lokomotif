<?php

namespace lms\feature\sending\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

use lms\feature\sending\SendLocomotiveHandler;
use lms\feature\sending\SendResult;

$locomotive_id = $_GET['locomotive_id'];
$destination_id = $_GET['destination_id'] ?? 0;


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
        // Cari driver_id dari lokomotif ini, lalu insert panggilan ke masinis
        $stmt = $db->prepare("SELECT driver_id FROM locomotive WHERE id = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("i", $locomotive_id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            if ($row && $row['driver_id']) {
                $driver_id = (int)$row['driver_id'];
                $ins = $db->prepare("INSERT INTO calling (driver_id, call_time) VALUES (?, NOW())");
                if ($ins) {
                    $ins->bind_param("i", $driver_id);
                    $ins->execute();
                    $ins->close();
                }
            }
        }
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=locomotive_send_success");
        break;
}
exit;