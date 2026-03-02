<?php
namespace lms\feature\maintenance_schedule\endpoint;

use DateTime;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;
use lms\feature\maintenance_schedule\ScheduleResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$locomotive_id = 1;
$start = new DateTime('2026-2-12');
$end = new DateTime('2026-2-13');

$locomotive = new InMemoryLocomotiveRepository([]);
$schedule = new InMemoryScheduleRepository([]);

$scheduler = new Scheduler($locomotive, $schedule);

$result = $scheduler->add_schedule($locomotive_id, $start, $end);

switch ($result) {
    case ScheduleResult::Success:
        echo "Schedule added successfully.";
        break;
    case ScheduleResult::ScheduleUnavailable:
        echo "The schedule is unavailable for the given time period.";
        break;
    case ScheduleResult::LocomotiveNotFound:
        echo "The specified locomotive was not found.";
        break;
}