<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;

require_once __DIR__ . "../../../../../vendor/autoload.php";


$id = $_GET["id"];

$maintenance_unit = new InMemoryMaintenanceUnitRepository([]);
$editor = new MaintenanceProgramEditor($maintenance_unit);

$result = $editor->delete_unit($id);
switch ($result) {
    case true:
        echo "Maintenance unit deleted successfully.";
        break;
    case false:
        echo "Failed to delete maintenance unit. Unit not found.";
        break;
}