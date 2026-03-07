<?php

namespace lms\feature\maintenance_program;

use lms\feature\maintenance_program\entities\IMaintenanceUnitRepository;

enum MaintenanceProgramEditorResult
{
    case Success;
    case UnitNotFound;
}

class MaintenanceProgramEditor
{
    private IMaintenanceUnitRepository $_repository;

    function __construct(IMaintenanceUnitRepository $repository) {
        $this->_repository = $repository;
    }

    private function normalize()
    {
        $units = $this->_repository->getAll();
        usort($units, function ($a, $b) {
            return $a->sequence_number <=> $b->sequence_number;
        });

        foreach ($units as $index => $unit) {
            $this->_repository->update($unit->id, $index + 1, $unit->unit);
        }
    }

    public function add_unit(string $unit)
    {
        $id = $this->_repository->count() + 1;
        $latest_sequence = 0;

        $this->_repository->insert($id, $latest_sequence + 1, $unit);

        $this->normalize();

        return MaintenanceProgramEditorResult::Success;
    }

    public function edit_unit(int $id, int $sequence_number, string $unit)
    {
        if ($this->_repository->get($id) === null) {
            return MaintenanceProgramEditorResult::UnitNotFound;
        }

        $this->_repository->update($id, $sequence_number, $unit);
        $this->normalize();

        return MaintenanceProgramEditorResult::Success;
    }

    public function delete_unit(int $id)
    {
        if ($this->_repository->get($id) === null) {
            return MaintenanceProgramEditorResult::UnitNotFound;
        }

        $this->_repository->delete($id);
        return MaintenanceProgramEditorResult::Success;
    }
}

