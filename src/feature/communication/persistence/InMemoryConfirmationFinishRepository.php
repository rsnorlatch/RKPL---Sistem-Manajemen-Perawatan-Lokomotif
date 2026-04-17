<?php

namespace lms\feature\communication\persistence;

use lms\feature\communication\entities\IConfirmationFinishRepository;
use lms\feature\communication\entities\ConfirmationFinish;
use DateTime;

class InMemoryConfirmationFinishRepository implements IConfirmationFinishRepository
{
    private array $confirmations = [];

    public function __construct(array $confirmations = [])
    {
        $this->confirmations = $confirmations;
    }

    public function count(): int
    {
        return count($this->confirmations);
    }

    public function insert(int $id, int $driver_id, int $call_id, DateTime $timestamp): void
    {
        $this->confirmations[$id - 1] = new ConfirmationFinish($id, $driver_id, $call_id, $timestamp);
    }

    public function get(int $id)
    {
        return $this->confirmations[$id - 1] ?? null;
    }

    public function getAll(): array
    {
        return array_values($this->confirmations);
    }

    public function update(int $id, int $driver_id, int $call_id, DateTime $timestamp): void
    {
        if (isset($this->confirmations[$id - 1])) {
            $this->confirmations[$id - 1]->driver_id = $driver_id;
            $this->confirmations[$id - 1]->call_id = $call_id;
            $this->confirmations[$id - 1]->timestamp = $timestamp;
        }
    }

    public function delete(int $id): void
    {
        unset($this->confirmations[$id - 1]);
    }
}
