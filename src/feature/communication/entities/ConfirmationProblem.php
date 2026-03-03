<?php

namespace lms\feature\communication\entities;

use DateTime;

class ConfirmationProblem
{
    public int $id;
    public int $driver_id;
    public int $call_id;
    public DateTime $timestamp;
    public string $problem;

    public function __construct(int $id, int $driver_id, int $call_id, DateTime $timestamp, string $problem)
    {
        $this->id = $id;
        $this->driver_id = $driver_id;
        $this->call_id = $call_id;
        $this->timestamp = $timestamp;
        $this->problem = $problem;
    }
}