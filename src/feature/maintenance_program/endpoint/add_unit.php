<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\MySqlMaintenanceUnitRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

$unit_name = $_POST['unit_name'];
$description = $_POST["description"];
$unit_type = $_POST['unit_type'];


$unit = new MySqlMaintenanceUnitRepository($db);
$editor = new MaintenanceProgramEditor($unit);

$result = $editor->add_unit($unit_name, $description, $unit_type);

switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        header("Location: ../../../../front-end/atur_program.php");
        /* echo "Maintenance unit added successfully."; */
        break;

    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to add maintenance unit. Unit not found.";
        break;
}
