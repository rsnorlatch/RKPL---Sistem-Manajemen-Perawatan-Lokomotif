<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$id = $_POST['id'];
$sequence_number = $_POST['sequence_number'];
$unit = $_POST['unit'];


$maintenance_unit = new MySqlMaintenanceUnitRepository($db);
$editor = new MaintenanceProgramEditor($maintenance_unit);

$current_unit = $maintenance_unit->get($id);

$result = $editor->edit_unit($id, $current_unit->sequence_number, $unit, $current_unit->description, $current_unit->unit_type);

switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        header("Location: ../../../../front-end/atur_program.php?status=$id");
        break;
    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to edit maintenance unit. Unit not found.";
        break;
}

var_dump($maintenance_unit->getAll());
