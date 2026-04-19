<?php

namespace lms\feature\sending;

require_once __DIR__ . "../../../../vendor/autoload.php";

use DateTime;
use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\MySqlOnSiteLocomotiveRepository;
use lms\feature\sending\entities\ISendRequestRepository;
use lms\feature\sending\entities\IStopRepository;
use lms\feature\sending\entities\Stop;
use lms\feature\sending\persistence\MySqlSendRequestRepository;
use lms\feature\sending\persistence\MySqlStopRepository;
use mysqli;


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

    public static function create_inmemory()
    {
        return new InMemorySendLocomotiveHandlerBuilder();
    }

    public static function create_mysql(mysqli $db)
    {
        return new SendLocomotiveHandler(
            new MySqlOnSiteLocomotiveRepository($db),
            new MySqlSendRequestRepository($db),
            new MySqlStopRepository($db)
        );
    }

    function handle(int $locomotive_id, int $destination_id)
    {
        $vacant_id = $this->_send_request->count() + 1;

        $locomotive_exists = count(
            array_filter(
                $this->_locomotives->getAll(),
                function (Locomotive $l) use ($locomotive_id) {
                    return $l->id == $locomotive_id;
                }
            )
        ) > 0;
        $destination_exists = count(
            array_filter(
                $this->_stops->getAll(),
                function (Stop $s) use ($destination_id) {
                    return $s->id == $destination_id;
                }
            )
        ) > 0;

        if (!$locomotive_exists && !$destination_exists) {
            return SendResult::DestinationAndLocomotiveNotFound;
        }

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
