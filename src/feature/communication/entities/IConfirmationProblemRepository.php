<?php

namespace lms\feature\communication\entities;

use DateTime;


interface IConfirmationProblemRepository
{
    public function count(): int;

    public function insert(int $id, int $driver_id, int $call_id, DateTime $timestamp, string $problem): void;

    public function get(int $id);

    public function getAll(): array;

    public function update(int $id, int $driver_id, int $call_id, DateTime $timestamp, string $problem): void;

    public function delete(int $id): void;
}