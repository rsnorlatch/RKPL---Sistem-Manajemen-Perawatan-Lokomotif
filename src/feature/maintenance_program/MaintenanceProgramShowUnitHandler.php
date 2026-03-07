<?php

namespace lms\feature\maintenance_program;

use lms\feature\maintenance_program\entities\IMaintenanceUnitRepository;

class MaintenanceProgramShowUnitHandler
{
    private IMaintenanceUnitRepository $_units;

    function __construct($_units)
    {
        $this->_units = $_units;
    }


    function handle()
    {
        return $this->_units->getAll();
    }
}
