<?php

namespace lms\feature\maintenance_schedule;

use DateTime;
use lms\feature\locomotive_management\entities\ILocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\maintenance_schedule\entities\IScheduleRepository;
use lms\feature\maintenance_schedule\entities\Schedule;

enum ScheduleResult
{
    case Success;
    case ScheduleUnavailable;
}

class Scheduler
{
    private ILocomotiveRepository $_locomotives;
    private IScheduleRepository $_schedule;

    function __construct(ILocomotiveRepository $_locomotives, IScheduleRepository $_schedule) {
        $this->_locomotives = $_locomotives;
        $this->_schedule = $_schedule;
    }

    private function is_unavailable(DateTime $start, DateTime $end) {
        return count(array_filter($this->_schedule->getAll(), function (Schedule $s) use ($start, $end) {
            return $start >= $s->start && $start <= $s->end ||
                $end >= $s->start && $end <= $s->end ||
                $start <= $s->start && $end >= $s->end;
        })) > 0;
    }

    function add_schedule(int $locomotive_id, DateTime $start, DateTime $end) {
        if ($this->is_unavailable($start, $end)) {
            return ScheduleResult::ScheduleUnavailable;
        }

        $latest_id = $this->_schedule->count();

        $this->_schedule->insert($latest_id, $start, $end, $locomotive_id);

        return ScheduleResult::Success;
    }
}