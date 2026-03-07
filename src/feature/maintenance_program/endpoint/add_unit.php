<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$new_unit = $_POST["unit"];

$unit = new MySqlMaintenanceUnitRepository($db);
$editor = new MaintenanceProgramEditor($unit);

$result = $editor->add_unit($new_unit);

switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        header("Location: ../../../../front-end/atur_program_perawatan.php?status=success");
        break;

    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to add maintenance unit. Unit not found.";
        break;
}
