<?php

namespace lms\feature\locomotive_management\persistence;

use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\locomotive_management\entities\OnSiteLocomotive;

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

    public function insert($id, $locomotive_id): void
    {
        array_push($this->locomotives, new OnSiteLocomotive($id, $locomotive_id));
    }

    public function get(int $id)
    {
        return array_filter($this->locomotives, function (OnSiteLocomotive $l) use ($id) {
            return $l->id == $id;
        })[0];
    }

    public function getAll(): array
    {
        return $this->locomotives;
    }

    public function update(int $id, int $locomotive_id): void
    {
        foreach ($this->locomotives as $l) {
            if ($l->id == $id) {
                $l->locomotive_id = $locomotive_id;
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
