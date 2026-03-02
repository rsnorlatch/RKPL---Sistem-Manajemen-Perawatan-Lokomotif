<?php

namespace lms\feature\maintenance_program\entities;

interface IMaintenanceUnitRepository
{
    public function count(): int;

    public function insert(int $id, int $sequence_number, string $unit): void;

    public function get(int $id);

    public function getAll(): array;

    public function update(int $id, int $sequence_number, string $unit): void;

    public function delete(int $id): void;
}