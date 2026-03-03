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

    public function add_unit(string $unit)
    {
        $id = $this->_repository->count() + 1;
        $latest_sequence = 0;

        foreach ($this->_repository->getAll() as $u) {
            if ($u->sequence_number > $latest_sequence) {
                $latest_sequence = $u->sequence_number;
            }
        }

        $this->_repository->insert($id, $latest_sequence + 1, $unit);

        return MaintenanceProgramEditorResult::Success;
    }

    public function edit_unit(int $id, int $sequence_number, string $unit)
    {
        if ($this->_repository->get($id) === null) {
            return MaintenanceProgramEditorResult::UnitNotFound;
        }

        $this->_repository->update($id, $sequence_number, $unit);
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

