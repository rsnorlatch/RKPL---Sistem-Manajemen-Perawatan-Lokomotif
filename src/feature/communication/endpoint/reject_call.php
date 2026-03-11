<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\DriverCallingController;
use lms\feature\communication\entities\Call;

use DateTIme;
use lms\feature\communication\persistence\MySqlAcceptedCallRepository;
use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\communication\persistence\MySqlConfirmationFinishRepository;
use lms\feature\communication\persistence\MySqlConfirmationProblemRepository;
use lms\feature\communication\persistence\MySqlRejectedCallRepository;
use lms\feature\locomotive_management\persistence\MySqlOnSiteLocomotiveRepository;
use lms\feature\communication\CallingResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$call_id = $_POST["call_id"];
$problem = $_POST["reason"];

$calls = new MySqlCallRepository($db);
$confirmationFinishes = new MySqlConfirmationFinishRepository($db);
$confirmationProblems = new MySqlConfirmationProblemRepository($db);
$acceptedCalls = new MySqlAcceptedCallRepository($db);
$rejectedCalls = new MySqlRejectedCallRepository($db);
$onsite_locomotives = new MySqlOnSiteLocomotiveRepository($db);
$controller = new DriverCallingController($calls, $confirmationFinishes, $confirmationProblems, $acceptedCalls, $rejectedCalls, $onsite_locomotives);

$result = $controller->reject_call((int)$call_id, $problem);
var_dump($result);

switch ($result) {
    case CallingResult::CallNotFound:
        header("Location: ../../../../front-end/panggilan.php?status=notfound");
        break;
    case CallingResult::Success:
        header("Location: ../../../../front-end/panggilan.php?status=success");
        break;
    default:
        http_response_code(500);
        echo json_encode(["error" => "An unexpected error occurred"]);
}
