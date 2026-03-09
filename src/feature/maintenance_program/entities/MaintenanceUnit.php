<?php

namespace lms\feature\maintenance_program\entities;

class MaintenanceUnit
{
    public int $id;
    public int $sequence_number;
    public string $unit_name;
    public string $description;
    public string $unit_type;

    function __construct(int $id, int $sequence_number, string $unit_name, string $description = "", string $unit_type = "")
    {
        $this->id = $id;
        $this->sequence_number = $sequence_number;
        $this->unit_name = $unit_name;
        $this->description = $description;
        $this->unit_type = $unit_type;
    }
}

