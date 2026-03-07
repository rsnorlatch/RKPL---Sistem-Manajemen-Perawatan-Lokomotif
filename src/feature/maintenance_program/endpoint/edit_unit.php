<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$id = $_GET['id'];
$sequence_number = $_GET['sequence_number'];
$unit = $_GET['unit'];

$maintenance_unit = new MySqlMaintenanceUnitRepository($db);
$editor = new MaintenanceProgramEditor($maintenance_unit);

$result = $editor->edit_unit($id, $sequence_number, $unit);
$editor->edit_unit($id, $sequence_number, $unit);

switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        header("Location: ../../../../front-end/atur_program_perawatan.php?edit=$id");
        break;
    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to edit maintenance unit. Unit not found.";
        break;
}

var_dump($maintenance_unit->getAll());

