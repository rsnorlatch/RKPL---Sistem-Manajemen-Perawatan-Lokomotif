<?php

namespace lms\feature\maintenance_program\entities;

class MaintenanceUnit
{
    public int $id;
    public int $sequence_number;
    public string $unit;

    function __construct(int $id, int $sequence_number, string $unit) {
        $this->id = $id;
        $this->sequence_number = $sequence_number;
        $this->unit = $unit;
    }
}