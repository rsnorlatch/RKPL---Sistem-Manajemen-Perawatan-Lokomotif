<?php

namespace lms\feature\maintenance_schedule\endpoint;

use DateTime;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$date_start = new DateTime('2026-2-12');
$date_end = new DateTime('2026-2-13');
$locomotive_id = 1;

$locomotive = new InMemoryLocomotiveRepository([]);
$schedule = new InMemoryScheduleRepository([]);
$scheduler = new Scheduler($locomotive, $schedule);

$result = $scheduler->edit_schedule($locomotive_id, $date_start, $date_end);

var_dump($result);

