<?php

namespace lms\feature\maintenance_schedule\entities;

use DateTime;

interface IScheduleRepository
{
    public function count(): int;

    public function insert(int $id, DateTime $start, DateTime $end, int $locomotive_id): void;

    public function get(int $id);

    public function getAll(): array;

    public function update(int $id, DateTime $start, DateTime $end, int $locomotive_id): void;

    public function delete(int $id): void;
}
