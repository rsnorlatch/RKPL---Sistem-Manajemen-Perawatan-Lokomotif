<?php

namespace lms\feature\sending;

require_once __DIR__ . "../../../../vendor/autoload.php";

use DateTime;
use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\sending\entities\ISendRequestRepository;
use lms\feature\sending\entities\IStopRepository;
use lms\feature\sending\entities\Stop;

enum SendResult
{
    case LocomotiveNotFound;
    case DestinationNotFound;
    case Success;
}

class SendLocomotiveHandler
{
    public IOnSiteLocomotiveRepository $_locomotives;
    public ISendRequestRepository $_send_request;
    public IStopRepository $_stops;

    function __construct(IOnSiteLocomotiveRepository $_locomotives, ISendRequestRepository $_send_request, IStopRepository $_stops)
    {
        $this->_locomotives = $_locomotives;
        $this->_send_request = $_send_request;
        $this->_stops = $_stops;
    }

    function handle(int $locomotive_id, int $destination_id)
    {
        $vacant_id = $this->_send_request->count() + 1;

        $locomotive_exists = count(array_filter($this->_locomotives->getAll(), function (Locomotive $l) use ($locomotive_id) {
            return $l->id == $locomotive_id;
        })) > 0;
        $destination_exists = count(array_filter($this->_stops->getAll(), function (Stop $s) use ($destination_id) {
            return $s->id == $destination_id;
        })) > 0;

        if (!$locomotive_exists) {
            return SendResult::LocomotiveNotFound;
        }

        if (!$destination_exists) {
            return SendResult::DestinationNotFound;
        }

        $this->_send_request->insert($vacant_id, $locomotive_id, $destination_id, new DateTime());
        $this->_locomotives->delete($locomotive_id);

        return SendResult::Success;
    }
}
