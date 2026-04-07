<?php

namespace lms\feature\sending\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;
use lms\feature\sending\entities\Stop;
use lms\feature\sending\persistence\InMemorySendRequestRepository;
use lms\feature\sending\persistence\InMemoryStopRepository;
use lms\feature\sending\SendLocomotiveHandler;

$locomotive_id = 1;
$destination_id = 1;

$locomotive = new InMemoryOnSiteLocomotiveRepository([
    new Locomotive(1, 1, "Locomotive 1")
]);
$send_request = new InMemorySendRequestRepository([]);
$stops = new InMemoryStopRepository([
    new Stop(1, "Stop 1", 200, 200)
]);

$handler = new SendLocomotiveHandler($locomotive, $send_request, $stops);

$result = $handler->handle($locomotive_id, $destination_id);

var_dump($result);

echo "\n";

var_dump($send_request->getAll());
