<?php

use lms\feature\maintenance_program\entities\MaintenanceUnit;
use lms\feature\maintenance_program\MaintenanceProgramEditor;
use lms\feature\maintenance_program\MaintenanceProgramEditorResult;
use lms\feature\maintenance_program\persistence\InMemoryMaintenanceUnitRepository;
use PHPUnit\Framework\TestCase;

final class MaintenanceProgramTest extends TestCase
{
    public function testShouldBeAbleToAddUnit()
    {
        $editor = MaintenanceProgramEditor::create_inmemory()->build();

        $editor->add_unit("name", "description", "type");

        $this->assertEquals([new MaintenanceUnit(1, 1, "name", "description", "type")], $editor->_units->getAll());
    }

    public function testEditingUnitThatDoesNotExist_ShouldReturnNotFoundStatus()
    {
        $editor = MaintenanceProgramEditor::create_inmemory()->build();

        $result = $editor->edit_unit(1, 1, "", "", "");

        $this->assertEquals(MaintenanceProgramEditorResult::UnitNotFound, $result);
    }

    public function testAddingMultipleUnit_ShouldHaveTheUnitsSorted()
    {
        $editor = MaintenanceProgramEditor::create_inmemory()->build();

        $editor->add_unit("one", "", "");
        $editor->add_unit("two", "", "");
        $editor->add_unit("three", "", "");

        $this->assertEquals([
            new MaintenanceUnit(1, 1, "one", "", ""),
            new MaintenanceUnit(2, 2, "two", "", ""),
            new MaintenanceUnit(3, 3, "three", "", ""),
        ], $editor->_units->getAll());
    }

    public function testItShouldOnlyRequireOneEditUnitCall_InOrderToSwapUnits()
    {
        $editor = MaintenanceProgramEditor::create_inmemory()
            ->with_unit(1, 1, "one", "", "")
            ->with_unit(2, 2, "two", "", "")
            ->with_unit(3, 3, "three", "", "")
            ->build();

        $editor->edit_unit(2, 3, "two", "", "");
        $editor->edit_unit(3, 2, "three", "", "");

        $this->assertEquals([
            new MaintenanceUnit(1, 1, "one", "", ""),
            new MaintenanceUnit(2, 3, "two", "", ""),
            new MaintenanceUnit(3, 2, "three", "", ""),
        ], $editor->_units->getAll());
    }
}
