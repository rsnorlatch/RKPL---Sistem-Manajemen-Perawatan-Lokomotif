<?php

namespace lms\feature\sending\endpoint;

use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;
use lms\feature\sending\persistence\InMemorySendRequestRepository;
use lms\feature\sending\persistence\InMemoryStopRepository;
use lms\feature\sending\SendLocomotiveHandler;

$locomotive_id = 1;
$destination_id = 1;

$locomotive = new InMemoryOnSiteLocomotiveRepository([]);
$send_request = new InMemorySendRequestRepository([]);
$stops = new InMemoryStopRepository([]);

$handler = new SendLocomotiveHandler($locomoive, $send_request, $stops);

$handler->handle($locomotive_id, $destination_id);
