<?php

namespace main;

require_once "./application/locomotive_calling_usecase.php";
require_once "./domain/i_locomotive_repository.php";

require_once "./domain/locomotive.php";
require_once "./persistent/i_locomotive_call_queue.php";
require_once "./persistent/inmemory_locomotive_repository.php";
require_once "./persistent/inmemory_locomotive_call_queue.php";

use main\application\LocomotiveCallingUsecase as LocomotiveCallingUsecase;

$db = [
  "1" => "bla"
];
$queue = [];

$call_loco_usecase = LocomotiveCallingUsecase::create_mocked($db, $queue);
$call_loco_usecase->execute("1");

echo $queue[0];
