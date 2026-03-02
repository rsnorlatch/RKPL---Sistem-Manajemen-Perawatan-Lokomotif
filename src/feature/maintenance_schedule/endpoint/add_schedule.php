<?php
namespace lms\feature\maintenance_schedule\endpoint;

use DateTime;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$locomotive_id = 1;
$start = new DateTime('2026-2-12');
$end = new DateTime('2026-2-13');

$locomotive = new InMemoryLocomotiveRepository([]);

if ($locomotive->get($locomotive_id) == null) {
    echo "locomotive not found";
}

$schedule = new InMemoryScheduleRepository([]);
$scheduler = new Scheduler($locomotive, $schedule);

$scheduler->add_schedule($locomotive_id, $start, $end);