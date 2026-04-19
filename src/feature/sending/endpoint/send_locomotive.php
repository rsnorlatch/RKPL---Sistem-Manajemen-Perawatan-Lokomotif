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
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php?status=locomotive_send_success");
        break;
}
