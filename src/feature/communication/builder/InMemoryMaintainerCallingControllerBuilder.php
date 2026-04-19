<?php

namespace lms\feature\communication\builder;

use DateTime;
use lms\feature\communication\entities\Call;
use lms\feature\communication\MaintainerCallingController;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;

class InMemoryMaintainerCallingControllerBuilder
{
    private $_calls = [];
    private $_locomotives = [];

    public function with_calls(int $id, int $driver_id, DateTime $timestamp)
    {
        array_push($this->_calls, new Call($id, $driver_id, $timestamp));

        return $this;
    }

    public function with_locomotive(int $id, int $driver_id, string $model)
    {
        array_push($this->_locomotives, new Locomotive($id, $driver_id, $model));

        return $this;
    }

    public function build()
    {
        return new MaintainerCallingController(
            new InMemoryCallRepository($this->_calls),
            new InMemoryLocomotiveRepository($this->_locomotives)
        );
    }
}
