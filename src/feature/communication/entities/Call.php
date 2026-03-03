<?php

namespace lms\feature\communication\entities;

use DateTime;

class Call
{
    public int $id;
    public int $driver_id;
    public DateTime $timestamp;

    public function __construct(int $id, int $driver_id, DateTime $timestamp)
    {
        $this->id = $id;
        $this->driver_id = $driver_id;
        $this->timestamp = $timestamp;
    }
}