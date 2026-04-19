<?php

namespace lms\feature\sending;

use ArrayObject;
use DateTime;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;
use lms\feature\sending\entities\SendRequest;
use lms\feature\sending\entities\Stop;
use lms\feature\sending\persistence\InMemorySendRequestRepository;
use lms\feature\sending\persistence\InMemoryStopRepository;

class InMemorySendLocomotiveHandlerBuilder
{
    private $_onsite_locomotives = [];
    private $_send_requests = [];
    private $_stops = [];

    public function with_onsite_locomotive(int $id, int $driver_id, string $model)
    {
        array_push($this->_onsite_locomotives, new Locomotive($id, $driver_id, $model));

        return $this;
    }

    public function with_send_request(int $id, int $locomotive_id, int $destination_id, DateTime $timestamp)
    {
        array_push($this->_send_requests, new SendRequest($id, $locomotive_id, $destination_id, $timestamp));

        return $this;
    }

    public function with_stop(int $id, string $name, float $x, float $y)
    {
        array_push($this->_stops, new Stop($id, $name, $x, $y));

        return $this;
    }

    public function build()
    {
        return new SendLocomotiveHandler(
            new InMemoryOnSiteLocomotiveRepository($this->_onsite_locomotives),
            new InMemorySendRequestRepository($this->_send_requests),
            new InMemoryStopRepository($this->_stops)
        );
    }
}
