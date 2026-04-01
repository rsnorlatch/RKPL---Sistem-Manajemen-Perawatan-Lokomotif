<?php

namespace lms\feature\maintenance_schedule\endpoint;

use DateTime;
use lms\feature\locomotive_management\persistence\MySqlLocomotiveRepository;
use lms\feature\maintenance_schedule\entities\Schedule;
use lms\feature\maintenance_schedule\persistence\MySqlScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;
use lms\feature\maintenance_schedule\ScheduleResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$locomotive_id = $_POST['locomotive_id'];
$start = $_POST['start'];
$end = $_POST['end'];


$locomotive = new MySqlLocomotiveRepository($db);
$schedule = new MySqlScheduleRepository($db);

$scheduler = new Scheduler($locomotive, $schedule);

$result = $scheduler->add_schedule($locomotive_id, new DateTime($start), new DateTime($end));

switch ($result) {
    case ScheduleResult::LocomotiveNotFound:
        header("Location: ../../../../front-end/jadwal.php?status=cannot_find_locomotive");
        break;

    case ScheduleResult::ScheduleUnavailable:
        header("Location: ../../../../front-end/jadwal.php?status=schedule_unavailable");
        break;

    case ScheduleResult::Success:
        header("Location: ../../../../front-end/jadwal.php?status=success");
        break;
}
