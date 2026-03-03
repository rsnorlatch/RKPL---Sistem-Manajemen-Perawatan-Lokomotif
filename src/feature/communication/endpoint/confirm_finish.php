<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;

require_once __DIR__."../../../../../vendor/autoload.php";

$calls = new InMemoryCallRepository([]);
$confirmationFinishes = new InMemoryConfirmationFinishRepository([]);
$confirmationProblems = new InMemoryConfirmationProblemRepository([]);
$controller = new DriverCallingController($calls, $confirmationFinishes, $confirmationProblems);

$result = $controller->confirm_finish(1);

var_dump($result);  
