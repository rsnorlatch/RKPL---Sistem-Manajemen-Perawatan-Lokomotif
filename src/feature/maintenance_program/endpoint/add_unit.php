<?php

namespace lms\feature\maintenance_program\endpoint;

use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;

require_once __DIR__."../../../../../vendor/autoload.php";

$id = $_GET["id"];
$sequence_number = $_GET["sequence_number"];
$unit = $_GET["unit"];

$unit = new InMemoryMaintenanceUnitRepository([]);
$editor = new MaintenanceProgramEditor($unit);
$result = $editor->add_unit($sequence_number, $unit);