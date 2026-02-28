<?php

namespace lms\feature\locomotive_management\persistence;

use lms\feature\locomotive_management\entities\ILocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;

class InMemoryLocomotiveRepository implements ILocomotiveRepository
{
    private array $locomotive = [];

    public function __construct(array $locomotives = [])
    {
        $this->locomotive = $locomotives;
    }

    public function count(): int
    {
        return count($this->locomotive);
    }

    public function insert(int $id, int $driver_id, string $model): void
    {
        $this->locomotive[$id] = new Locomotive($id, $driver_id, $model);
    }

    public function get(int $id)
    {
        return $this->locomotive[$id] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->locomotive);
    }

    public function update(int $id, int $driver_id, string $model): void
    {
        if (isset($this->locomotive[$id])) {
            $this->locomotive[$id]->driver_id = $driver_id;
            $this->locomotive[$id]->model = $model;
        }
    }

    public function delete(int $id): void
    {
        unset($this->locomotive[$id]);
    }
}
