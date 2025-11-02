<?php

namespace main;

require_once "./application/locomotive_calling_usecase.php";
require_once "./domain/i_locomotive_repository.php";

require_once "./domain/locomotive.php";
require_once "./persistent/i_locomotive_call_queue.php";
require_once "./persistent/inmemory_locomotive_repository.php";
require_once "./persistent/inmemory_locomotive_call_queue.php";

use main\application\LocomotiveCallingUsecase as LocomotiveCallingUsecase;
use main\persistence\InMemoryLocomotiveRepository as InMemoryLocomotiveRepository;
use main\persistence\InMemoryLocomotiveCallQueue as InMemoryLocomotiveCallQueue;

$loco_repo = new InMemoryLocomotiveRepository([
  "1" => "bla"
]);
$loco_callqueue = new InMemoryLocomotiveCallQueue([]);

$call_loco_usecase = new LocomotiveCallingUsecase($loco_repo, $loco_callqueue);
$call_loco_usecase->execute("1");

var_dump($loco_callqueue->get_queue());
