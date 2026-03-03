<?php

namespace lms\feature\locomotive_management\entities;

class Locomotive
{
    public int $id;
    public int $driver_id;
    public string $model;

    function __construct(int $id, int $driver_id, string $model) {
        $this->id = $id;
        $this->driver_id = $driver_id;
        $this->model = $model;
    }
}