<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\entities\Call;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;

use DateTime;

require_once __DIR__."../../../../../vendor/autoload.php";

$call_id = $_GET["call_id"];
$problem = $_GET["problem"];

$calls = new InMemoryCallRepository([]);
$confirmationFinishes = new InMemoryConfirmationFinishRepository([]);
$confirmationProblems = new InMemoryConfirmationProblemRepository([]);
$controller = new DriverCallingController($calls, $confirmationFinishes, $confirmationProblems);

$result = $controller->confirm_problem($call_id, $problem);

var_dump($result);
