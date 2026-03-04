<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\entities\Call;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;
use lms\feature\communication\persistence\InMemoryAcceptedCallRepository;
use lms\feature\communication\persistence\InMemoryRejectedCallRepository;

use DateTIme;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$call_id = $_GET["call_id"];

$calls = new InMemoryCallRepository([
    new Call(1, 1, new DateTime(), "Test Call"),
    new Call(2, 1, new DateTime(), "Test Call")
]);
$confirmationFinishes = new InMemoryConfirmationFinishRepository([]);
$confirmationProblems = new InMemoryConfirmationProblemRepository([]);
$acceptedCalls = new InMemoryAcceptedCallRepository([]);
$rejectedCalls = new InMemoryRejectedCallRepository([]);
$controller = new DriverCallingController($calls, $confirmationFinishes, $confirmationProblems, $acceptedCalls, $rejectedCalls);

$result = $controller->accept_call($call_id);
var_dump($result);
