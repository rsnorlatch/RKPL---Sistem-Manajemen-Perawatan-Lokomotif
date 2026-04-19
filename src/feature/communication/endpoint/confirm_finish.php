<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\CallingResult;
use lms\feature\communication\DriverCallingController;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$id = $_POST['id'];

$controller = DriverCallingController::create_mysql($db);

$result = $controller->confirm_finish($id);


switch ($result) {
    case CallingResult::Success:
        header("Location: ../../../../front-end/dashboard_masinis.php?status=finish_confirmed");
        break;
    case CallingResult::CallNotFound:
        echo "Failed to confirm finish. Call not found.";
        break;
    case CallingResult::LocomotiveNotFound:
        echo "Failed to confirm finish. Locomotive not found.";
        break;
}
