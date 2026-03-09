<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../../db/lms.php";


$id = $_POST["id"];

$maintenance_unit = new MySqlMaintenanceUnitRepository($db);
$editor = new MaintenanceProgramEditor($maintenance_unit);

$result = $editor->delete_unit($id);
switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        header("Location: ../../../../front-end/atur_program.php?status=deleted");
        break;
    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to delete maintenance unit. Unit not found.";
        break;
}
