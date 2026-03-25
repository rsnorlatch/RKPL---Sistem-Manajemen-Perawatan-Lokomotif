<?php

namespace lms\feature\maintenance_schedule\endpoint;

require_once "../../../../vendor/autoload.php";

use lms\feature\maintenance_schedule\Scheduler;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\entities\Schedule;

use DateTime;
use lms\feature\locomotive_management\entities\Locomotive;
use ReflectionClass;

$locomotives = new InMemoryLocomotiveRepository([
    new Locomotive(1, 1, "model-1")
]);

$schedules = new InMemoryScheduleRepository([
    new Schedule(1, new DateTime('2023-04-01 10:00:00'), new DateTime('2023-04-05 18:00:00'), 1)
]);

$scheduler = new Scheduler($locomotives, $schedules);
$scheduler_reflection = new ReflectionClass($scheduler);

$is_unavailable = $scheduler_reflection->getMethod("is_unavailable");
$result = $is_unavailable->invokeArgs($scheduler, [new DateTime('2023-04-06 09:00:00'), new DateTime('2023-04-07 15:00:00')]);

var_dump($result);
