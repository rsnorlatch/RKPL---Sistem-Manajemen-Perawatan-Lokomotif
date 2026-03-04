<?php
namespace lms\feature\maintenance_schedule\endpoint;

use DateTime;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\entities\Schedule;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\maintenance_schedule\persistence\MySqlScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;
use lms\feature\maintenance_schedule\ScheduleResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__."../../../../db/lms.php";

$locomotive_id = 1;
$start = new DateTime('2026-2-12');
$end = new DateTime('2026-2-13');

$locomotive = new InMemoryLocomotiveRepository([ ]);
$schedule = new MySqlScheduleRepository($db);

$scheduler = new Scheduler($locomotive, $schedule);

$result = $scheduler->add_schedule($locomotive_id, $start, $end);

var_dump($schedule->getAll());