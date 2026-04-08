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
$destination_id = $_GET['destination_id'] ?? 0;

$locomotive = new InMemoryOnSiteLocomotiveRepository([
    new Locomotive(1, 1, "Locomotive 1")
]);
$send_request = new InMemorySendRequestRepository([]);
$stops = new InMemoryStopRepository([
    new Stop(1, "Stop 1", -7.801389, 110.364444),
    new Stop(2, "Stop 2", -7.802500, 110.365000),
    new Stop(3, "Stop 3", -7.803200, 110.366100),
    new Stop(4, "Stop 4", -7.804000, 110.367200),
    new Stop(5, "Stop 5", -7.805100, 110.368300)
]);

$handler = new SendLocomotiveHandler($locomotive, $send_request, $stops);

$result = $handler->handle($locomotive_id, $destination_id);

var_dump($result);

var_dump($destination_id);

echo "\n";

var_dump($send_request->getAll());
