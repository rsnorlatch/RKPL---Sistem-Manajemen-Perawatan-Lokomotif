<?php

namespace lms\feature\maintenance_program;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;

class InMemoryMaintenanceProgramEditorBuilder
{
    private $_units = [];

    public function with_unit(int $id, int $sequence_number, string $unit_name, string $description, string $unit_type)
    {
        array_push($this->_units, new MaintenanceUnit($id, $sequence_number, $unit_name, $description, $unit_type));

        return $this;
    }

    public function build()
    {
        return new MaintenanceProgramEditor(new InMemoryMaintenanceUnitRepository($this->_units));
    }
}
