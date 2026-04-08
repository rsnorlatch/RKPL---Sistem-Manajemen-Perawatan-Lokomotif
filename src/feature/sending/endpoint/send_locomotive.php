<?php

namespace lms\feature\sending\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

use lms\feature\locomotive_management\persistence\MySqlOnSiteLocomotiveRepository;
use lms\feature\sending\persistence\MySqlSendRequestRepository;
use lms\feature\sending\persistence\MySqlStopRepository;
use lms\feature\sending\SendLocomotiveHandler;
use lms\feature\sending\SendResult;

$locomotive_id = 1;
$destination_id = $_GET['destination_id'] ?? 0;

$locomotive = new MySqlOnSiteLocomotiveRepository($db);
$send_request = new MySqlSendRequestRepository($db);
$stops = new MySqlStopRepository($db);

$handler = new SendLocomotiveHandler($locomotive, $send_request, $stops);

$result = $handler->handle($locomotive_id, $destination_id);

switch ($result) {
    case SendResult::DestinationNotFound:
        header("Location: ../../../../front-end/kirim_lokomotif.php?status=destination_not_found");
        break;

    case SendResult::LocomotiveNotFound:
        header("Location: ../../../../front-end/kirim_lokomotif.php?status=locomotive_not_found");
        break;

    case SendResult::Success:
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=locomotive_send_success");
        break;
}
