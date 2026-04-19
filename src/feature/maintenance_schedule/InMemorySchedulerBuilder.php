<?php

namespace lms\feature\maintenance_schedule;

use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\maintenance_schedule\entities\Schedule;
use lms\feature\maintenance_schedule\persistence\InMemoryScheduleRepository;
use lms\feature\maintenance_schedule\Scheduler;

use DateTime;

class InMemorySchedulerBuilder
{
    private $_locomomotives = [];
    private $_schedules = [];

    public function with_locomotive(int $id, int $driver_id, string $model)
    {
        array_push($this->_locomomotives, new Locomotive($id, $driver_id, $model));

        return $this;
    }

    public function with_schedule(int $id, DateTime $start, DateTime $end, int $locomotive_id)
    {
        array_push($this->_schedules, new Schedule($id, $start, $end, $locomotive_id));

        return $this;
    }

    public function build()
    {
        return new Scheduler(
            new InMemoryLocomotiveRepository($this->_locomomotives),
            new InMemoryScheduleRepository($this->_schedules)
        );
    }
}
