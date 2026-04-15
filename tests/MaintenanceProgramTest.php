<?php

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

final class MaintenanceProgramTest extends TestCase
{
    public function testShouldBeAbleToAddUnit()
    {
        $units = new InMemoryMaintenanceUnitRepository([]);
        $editor = new MaintenanceProgramEditor($units);

        $editor->add_unit("name", "description", "type");

        $this->assertEquals([new MaintenanceUnit(1, 1, "name", "description", "type")], $units->getAll());
    }

    public function testEditingUnitThatDoesNotExist_ShouldReturnNotFoundStatus()
    {
        $units = new InMemoryMaintenanceUnitRepository([]);
        $editor = new MaintenanceProgramEditor($units);

        $result = $editor->edit_unit(1, 1, "", "", "");

        $this->assertEquals(MaintenanceProgramEditorResult::UnitNotFound, $result);
    }

    public function testAddingMultipleUnit_ShouldHaveTheUnitsSorted()
    {
        $units = new InMemoryMaintenanceUnitRepository([]);
        $editor = new MaintenanceProgramEditor($units);

        $editor->add_unit("one", "", "");
        $editor->add_unit("two", "", "");
        $editor->add_unit("three", "", "");

        $this->assertEquals([
            new MaintenanceUnit(1, 1, "one", "", ""),
            new MaintenanceUnit(2, 2, "two", "", ""),
            new MaintenanceUnit(3, 3, "three", "", ""),
        ], $units->getAll());
    }

    public function testItShouldOnlyRequireOneEditUnitCall_InOrderToSwapUnits()
    {
        $units = new InMemoryMaintenanceUnitRepository([
            new MaintenanceUnit(1, 1, "one", "", ""),
            new MaintenanceUnit(2, 2, "two", "", ""),
            new MaintenanceUnit(3, 3, "three", "", ""),
        ]);
        $editor = new MaintenanceProgramEditor($units);

        $editor->edit_unit(2, 3, "two", "", "");
        $editor->edit_unit(3, 2, "three", "", "");

        $this->assertEquals([
            new MaintenanceUnit(1, 1, "one", "", ""),
            new MaintenanceUnit(2, 3, "two", "", ""),
            new MaintenanceUnit(3, 2, "three", "", ""),
        ], $units->getAll());
    }
}
