<?php

namespace lms\feature\locomotive_management\entities;

interface ILocomotiveRepository
{
    public function count(): int;

    public function insert(int $id, int $driver_id, string $model): void;

    public function get(int $id): Locomotive | null;

    public function getByDriverId(int $driver_id): Locomotive | null;

    public function getAll(): array;

    public function update(int $id, int $driver_id, string $model): void;

    public function delete(int $id): void;
}
