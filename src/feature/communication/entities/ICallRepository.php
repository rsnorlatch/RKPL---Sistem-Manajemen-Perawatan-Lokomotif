<?php

namespace lms\feature\communication\entities;

use DateTime;

interface ICallRepository
{
    public function count(): int;

    public function insert(int $id, int $driver_id, DateTime $timestamp): void;

    public function get(int $id): Call | null;

    public function getAll(): array;

    public function update(int $id, int $driver_id, DateTime $timestamp): void;

    public function delete(int $id): void;
}
