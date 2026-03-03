<?php

namespace lms\feature\maintenance_schedule\entities;
use DateTime;

class Schedule
{
    public int $id;
    public DateTime $start;
    public DateTime $end;
    public int $locomotive_id;

    function __construct(int $id, DateTime $start, DateTime $end, int $locomotive_id)
    {
        $this->id = $id;
        $this->start = $start;
        $this->end = $end;
        $this->locomotive_id = $locomotive_id;
    }
}