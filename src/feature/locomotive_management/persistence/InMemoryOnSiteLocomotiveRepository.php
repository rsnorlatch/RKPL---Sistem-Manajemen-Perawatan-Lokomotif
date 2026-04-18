<?php

namespace lms\feature\locomotive_management\persistence;

use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;

class InMemoryOnSiteLocomotiveRepository implements IOnSiteLocomotiveRepository
{
    public array $locomotives;

    function __construct(array $locomotives)
    {
        $this->locomotives = $locomotives;
    }

    public function count(): int
    {
        return count($this->locomotives);
    }

    public function insert(int $id, int $driver_id, string $model): void
    {
        array_push($this->locomotives, new Locomotive($id, $driver_id, $model));
    }

    public function get(int $id)
    {
        return array_filter($this->locomotives, function (Locomotive $l) use ($id) {
            return $l->id == $id;
        })[0];
    }

    public function getAll(): array
    {
        return $this->locomotives;
    }

    public function update(int $id, int $driver_id, string $model): void
    {
        foreach ($this->locomotives as $l) {
            if ($l->id == $id) {
                $l->driver_id = $driver_id;
                $l->model = $model;
            }
        }
    }

    public function delete(int $id): void
    {
        foreach ($this->locomotives as $l) {
            if ($l->id == $id) {
                unset($l);
            }
        }
    }
}
