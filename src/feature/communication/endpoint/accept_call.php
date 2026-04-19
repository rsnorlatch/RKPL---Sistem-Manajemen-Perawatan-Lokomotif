<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;

use lms\feature\communication\CallingResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$call_id = $_POST["call_id"];

$controller = DriverCallingController::create_mysql($db);

$result = $controller->accept_call($call_id);


switch ($result) {
    case CallingResult::Success:
        header("Location: ../../../../front-end/panggilan.php?status=success");
        break;

    case CallingResult::CallNotFound:
        header("Location: ../../../../front-end/panggilan.php?status=call_not_found");
        break;
}
