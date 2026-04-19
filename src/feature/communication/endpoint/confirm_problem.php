<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;


require_once __DIR__ . "../../../../../vendor/autoload.php";

$call_id = $_GET["call_id"];
$problem = $_GET["problem"];

$controller = DriverCallingController::create_mysql($db);

$result = $controller->confirm_problem($call_id, $problem);

var_dump($result);
