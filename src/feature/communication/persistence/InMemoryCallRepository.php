<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\ICallRepository;
use lms\feature\communication\entities\Call;
use DateTime;

class InMemoryCallRepository implements ICallRepository
{
    private array $calls = [];

    public function __construct(array $calls = [])
    {
        $this->calls = $calls;
    }

    public function count(): int
    {
        return count($this->calls);
    }

    public function insert(int $id, int $driver_id, DateTime $timestamp): void
    {
        $this->calls[$id] = new Call($id, $driver_id, $timestamp);
    }

    public function get(int $id): Call | null
    {
        return $this->calls[$id] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->calls);
    }

    public function update(int $id, int $driver_id, DateTime $timestamp): void
    {
        if (isset($this->calls[$id])) {
            $this->calls[$id]->driver_Id = $driver_id;
            $this->calls[$id]->timestamp = $timestamp;
        }
    }

    public function delete(int $id): void
    {
        unset($this->calls[$id]);
    }
}
