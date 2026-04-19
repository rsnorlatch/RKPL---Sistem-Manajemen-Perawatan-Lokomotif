<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\MaintainerCallingController;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$locomotive_id = $_GET["locomotive_id"];

$controller = MaintainerCallingController::create_mysql($db);

$result = $controller->call_locomotive($locomotive_id);
var_dump($result);
