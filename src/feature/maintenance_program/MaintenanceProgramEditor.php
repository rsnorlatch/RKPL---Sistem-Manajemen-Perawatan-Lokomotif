<?php

namespace lms\feature\maintenance_program;

use lms\feature\maintenance_program\entities\IMaintenanceUnitRepository;
use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;
use lms\feature\maintenance_schedule\InMemorySchedulerBuilder;
use mysqli;

enum MaintenanceProgramEditorResult
{
    case Success;
    case UnitNotFound;
}

class MaintenanceProgramEditor
{
    public IMaintenanceUnitRepository $_units;

    function __construct(IMaintenanceUnitRepository $repository)
    {
        $this->_units = $repository;
    }

    public static function create_inmemory()
    {
        return new InMemoryMaintenanceProgramEditorBuilder();
    }

    public static function create_mysql(mysqli $db)
    {
        return new MaintenanceProgramEditor(new MySqlMaintenanceUnitRepository($db));
    }

    private function normalize()
    {
        $units = $this->_units->getAll();
        foreach (array_reverse($units) as $index => $unit) {
            $newSequence = count($units) - $index;
            $this->_units->update(
                $unit->id,
                $newSequence,
                $unit->unit_name,
                $unit->description,
                $unit->unit_type
            );
        }
    }

    public function add_unit(string $unit_name, string $description, string $unit_type)
    {
        $id = $this->_units->count() + 1;
        $latest_sequence = 0;

        $this->_units->insert($id, $latest_sequence + 1, $unit_name, $description, $unit_type);

        $this->normalize();

        return MaintenanceProgramEditorResult::Success;
    }

    public function edit_unit(int $id, int $sequence_number, string $unit_name, string $description, string $unit_type)
    {
        if ($this->_units->get($id) === null) {
            return MaintenanceProgramEditorResult::UnitNotFound;
        }

        $this->_units->update($id, $sequence_number, $unit_name, $description, $unit_type);
        /* $this->normalize(); */

        return MaintenanceProgramEditorResult::Success;
    }

    public function delete_unit(int $id)
    {
        if ($this->_units->get($id) === null) {
            return MaintenanceProgramEditorResult::UnitNotFound;
        }

        $this->_units->delete($id);
        return MaintenanceProgramEditorResult::Success;
    }
}
