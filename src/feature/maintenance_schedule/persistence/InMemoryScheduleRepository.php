<?php

namespace lms\feature\maintenance_schedule\persistence;

require_once "../../../../vendor/autoload.php";

use lms\feature\maintenance_schedule\entities\IScheduleRepository;
use lms\feature\maintenance_schedule\entities\Schedule;

use DateTime;

class InMemoryScheduleRepository implements IScheduleRepository
{
    private array $schedules = [];

    public function __construct(array $schedules = [])
    {
        $this->schedules = $schedules;
    }

    public function count(): int
    {
        return count($this->schedules);
    }

    public function insert(int $id, DateTime $start, DateTime $end, int $locomotive_id): void
    {
        $this->schedules[$id] = new Schedule($id, $start, $end, $locomotive_id);
    }

    public function get(int $id)
    {
        return $this->schedules[$id] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->schedules);
    }

    public function update(int $id, DateTime $start, DateTime $end, int $locomotive_id): void
    {
        if (isset($this->schedules[$id])) {
            $this->schedules[$id]->start = $start;
            $this->schedules[$id]->end = $end;
            $this->schedules[$id]->locomotive_id = $locomotive_id;
        }
    }

    public function delete(int $id): void
    {
        unset($this->schedules[$id]);
    }
}

