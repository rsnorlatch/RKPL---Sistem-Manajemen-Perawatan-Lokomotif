<?php

namespace lms\feature\locomotive_management\persistence;

require_once __DIR__ . "../../../../../vendor/autoload.php";

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
        $this->locomotive[$id - 1] = new Locomotive($id, $driver_id, $model);
    }

    public function get(int $id): Locomotive | null
    {
        return $this->locomotive[$id - 1] ?? null;
    }

    public function getByDriverId(int $driver_id): Locomotive | null
    {
        return array_shift(
            array_values(
                array_filter(
                    $this->locomotive,
                    function (Locomotive $l) use ($driver_id) {
                        return $l->driver_id == $driver_id;
                    }
                )
            )
        );
    }

    public function getAll(): array
    {
        return array_values($this->locomotive);
    }

    public function update(int $id, int $driver_id, string $model): void
    {
        if (isset($this->locomotive[$id - 1])) {
            $this->locomotive[$id - 1]->driver_id = $driver_id;
            $this->locomotive[$id - 1]->model = $model;
        }
    }

    public function delete(int $id): void
    {
        unset($this->locomotive[$id - 1]);
    }
}
