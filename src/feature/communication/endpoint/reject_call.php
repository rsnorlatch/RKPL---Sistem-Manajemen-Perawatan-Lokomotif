<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\CallingResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$call_id = $_POST["call_id"];
$problem = $_POST["reason"];

$controller = DriverCallingController::create_mysql($db);

$result = $controller->reject_call((int)$call_id, $problem);
var_dump($result);

switch ($result) {
    case CallingResult::CallNotFound:
        header("Location: ../../../../front-end/panggilan.php?status=notfound");
        break;
    case CallingResult::Success:
        header("Location: ../../../../front-end/panggilan.php?status=success");
        break;
    default:
        http_response_code(500);
        echo json_encode(["error" => "An unexpected error occurred"]);
}
