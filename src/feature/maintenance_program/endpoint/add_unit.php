<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;

require_once __DIR__."../../../../../vendor/autoload.php";

$new_unit = $_POST["unit"];

$unit = new InMemoryMaintenanceUnitRepository([]);
$editor = new MaintenanceProgramEditor($unit);

$result = $editor->add_unit($new_unit);

switch ($result) {
    case MaintenanceProgramEditorResult::Success:
        echo "Maintenance unit added successfully.";
        break;
    
    case MaintenanceProgramEditorResult::UnitNotFound:
        echo "Failed to add maintenance unit. Unit not found.";
        break;
}

var_dump($unit->getAll());