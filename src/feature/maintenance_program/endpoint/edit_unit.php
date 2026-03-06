<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$id = 1;
$sequence_number = 2;
$unit = "Penggantian Filter";

$maintenance_unit = new InMemoryMaintenanceUnitRepository([
    new MaintenanceUnit(1, 1, "Pengecekan Rutin"),
    new MaintenanceUnit(2, 2, "Pembersihan Komponen"),
    new MaintenanceUnit(3, 3, "Penggantian Oli"),
]);
$editor = new MaintenanceProgramEditor($maintenance_unit);

$result = $editor->edit_unit($id, $sequence_number, $unit);
$editor->edit_unit(3, 1, "Penggantian Filter"); 

switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        echo "Maintenance unit edited successfully.";
        break;
    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to edit maintenance unit. Unit not found.";
        break;
}

var_dump($maintenance_unit->getAll());