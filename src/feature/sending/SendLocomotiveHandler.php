<?php

namespace lms\feature\sending;

require_once __DIR__ . "../../../../vendor/autoload.php";

use DateTime;
use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\sending\entities\ISendRequestRepository;
use lms\feature\sending\entities\IStopRepository;

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
        $this->_send_request->insert($vacant_id, $locomotive_id, $destination_id, new DateTime());
    }
}
