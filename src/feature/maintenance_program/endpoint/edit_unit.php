<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;

require_once __DIR__ . "../../../../../vendor/autoload.php";

$id = $_GET["id"];
$sequence_number = $_GET["sequence_number"];
$unit = $_GET["unit"];

$maintenance_unit = new InMemoryMaintenanceUnitRepository([]);
$editor = new MaintenanceProgramEditor($maintenance_unit);

$result = $editor->edit_unit($id, $sequence_number, $unit);


switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        echo "Maintenance unit edited successfully.";
        break;
    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to edit maintenance unit. Unit not found.";
        break;
}