<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\MaintainerCallingController;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$locomotive_id = $_GET["locomotive_id"];

$calls = new InMemoryCallRepository([]);
$locomotives = new InMemoryLocomotiveRepository([]);
$controller = new MaintainerCallingController($calls, $locomotives);

$result = $controller->call_locomotive($locomotive_id);
var_dump($result);

