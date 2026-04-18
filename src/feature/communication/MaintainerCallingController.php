<?php

namespace lms\feature\communication;

require_once __DIR__ . '../../../../vendor/autoload.php';

use lms\feature\communication\entities\ICallRepository;
use lms\feature\locomotive_management\entities\ILocomotiveRepository;

use DateTime;

enum CallingResult
{
    case Success;
    case LocomotiveNotFound;
    case CallNotFound;
}

class MaintainerCallingController
{
    public ICallRepository $_call;
    public ILocomotiveRepository $_locomotive;

    public function __construct(ICallRepository $callRepository, ILocomotiveRepository $_locomotive)
    {
        $this->_call = $callRepository;
        $this->_locomotive = $_locomotive;
    }

    public function call_locomotive(int $locomotive_id)
    {
        $locomotive = $this->_locomotive->get($locomotive_id);

        if ($locomotive == null) {
            return CallingResult::LocomotiveNotFound;
        }

        $driver_id = $locomotive->driver_id;
        $latest_id = $this->_call->count() + 1;

        $this->_call->insert($latest_id, $driver_id, new DateTime());

        return CallingResult::Success;
    }
}
