<?php

namespace lms\feature\communication;

require_once __DIR__."../../../../vendor/autoload.php";

use lms\feature\communication\entities\ICallRepository;
use lms\feature\communication\CallingResult;
use lms\feature\communication\entities\IConfirmationFinishRepository;
use lms\feature\communication\entities\IConfirmationProblemRepository;

use DateTime;

class DriverCallingController
{
    private ICallRepository $_calls;
    private IConfirmationFinishRepository $_confirmationFinishes;
    private IConfirmationProblemRepository $_confirmationProblems;

    function __construct(ICallRepository $calls, IConfirmationFinishRepository $confirmationFinishes, IConfirmationProblemRepository $confirmationProblems)
    {
        $this->_calls = $calls;
        $this->_confirmationFinishes = $confirmationFinishes; 
        $this->_confirmationProblems = $confirmationProblems;
    }

    public function confirm_finish(int $call_id)
    {
        $call = $this->_calls->get($call_id);
        if ($call == null) {
            return CallingResult::CallNotFound;
        }

        $this->_confirmationFinishes->insert(
            $this->_confirmationFinishes->count() + 1,
            $call->driver_id,
            $call_id,
            new DateTime()
        );

        return CallingResult::Success;
    }

    public function confirm_problem(int $call_id, string $problem)
    {
        $call = $this->_calls->get($call_id);
        if ($call == null) {
            return CallingResult::CallNotFound;
        }

        $this->_confirmationProblems->insert(
            $this->_confirmationProblems->count(),
            $call->driver_id,
            $call_id,
            new DateTime(),
            $problem
        );

        return CallingResult::Success;
    }
}