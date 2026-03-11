<?php

namespace lms\feature\communication\endpoint;

use lms\feature\communication\CallingResult;
use lms\feature\communication\DriverCallingController;
use lms\feature\communication\persistence\MySqlCallRepository;
use lms\feature\communication\persistence\MySqlConfirmationFinishRepository;
use lms\feature\communication\persistence\MySqlConfirmationProblemRepository;
use lms\feature\communication\persistence\MySqlAcceptedCallRepository;
use lms\feature\communication\persistence\MySqlRejectedCallRepository;
use lms\feature\locomotive_management\persistence\MySqlOnSiteLocomotiveRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$id = $_POST['id'];

$calls = new MySqlCallRepository($db);
$confirmationFinishes = new MySqlConfirmationFinishRepository($db);
$confirmationProblems = new MySqlConfirmationProblemRepository($db);
$acceptedCalls = new MySqlAcceptedCallRepository($db);
$rejectedCalls = new MySqlRejectedCallRepository($db);
$onsiteLocomoive = new MySqlOnSiteLocomotiveRepository($db);

$controller = new DriverCallingController($calls, $confirmationFinishes, $confirmationProblems, $acceptedCalls, $rejectedCalls, $onsiteLocomoive);

$result = $controller->confirm_finish($id);


switch ($result) {
    case CallingResult::Success:
        header("Location: ../../../../front-end/dashboard_masinis.php?status=finish_confirmed");
        break;
    case CallingResult::CallNotFound:
        echo "Failed to confirm finish. Call not found.";
        break;
    case CallingResult::LocomotiveNotFound:
        echo "Failed to confirm finish. Locomotive not found.";
        break;
}
