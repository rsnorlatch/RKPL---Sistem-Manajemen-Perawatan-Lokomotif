<?php

namespace lms\feature\maintenance_program\persistence;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\entities\IMaintenanceUnitRepository;

class InMemoryMaintenanceUnitRepository implements IMaintenanceUnitRepository
{
    private array $_units;

    function __construct(array $_units)
    {
        $this->_units = $_units;
    }

    public function count(): int
    {
        return count($this->_units);
    }

    public function insert(int $id, int $sequence_number, string $unit_name, string $description, string $unit_type): void
    {
        $this->_units[] = new MaintenanceUnit($id, $sequence_number, $unit_name, $description, $unit_type);
    }

    public function get(int $id)
    {
        foreach ($this->_units as $unit) {
            if ($unit->id == $id) {
                return $unit;
            }
        }

        return null;
    }

    /**
     * @return MaintenanceUnit[]
     **/
    public function getAll(): array
    {
        return $this->_units;
    }

    public function update(int $id, int $sequence_number, string $unit_name, string $description, string $unit_type): void
    {
        foreach ($this->_units as &$u) {
            if ($u->id == $id) {
                $u->sequence_number = $sequence_number;
                $u->unit_name = $unit_name;
                $u->description = $description;
                $u->unit_type = $unit_type;
                break;
            }
        }
    }

    public function delete(int $id): void
    {
        foreach ($this->_units as $i => $u) {
            if ($u->id == $id) {
                array_splice($this->_units, $i, 1);
                break;
            }
        }
    }
}
