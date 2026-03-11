<?php

namespace lms\feature\communication;

require_once __DIR__ . "../../../../vendor/autoload.php";

use lms\feature\communication\entities\ICallRepository;
use lms\feature\communication\CallingResult;
use lms\feature\communication\entities\IConfirmationFinishRepository;
use lms\feature\communication\entities\IConfirmationProblemRepository;
use lms\feature\communication\entities\IAcceptedCallRepository;
use lms\feature\communication\entities\IRejectedCallRepository;

use DateTime;
use lms\feature\locomotive_management\entities\IOnSiteLocomotiveRepository;

class DriverCallingController
{
    private ICallRepository $_calls;
    private IConfirmationFinishRepository $_confirmationFinishes;
    private IConfirmationProblemRepository $_confirmationProblems;
    private IAcceptedCallRepository $_acceptedCalls;
    private IRejectedCallRepository $_rejectedCalls;
    private IOnSiteLocomotiveRepository $_onSiteLocomotives;

    function __construct(
        ICallRepository $calls,
        IConfirmationFinishRepository $confirmationFinishes,
        IConfirmationProblemRepository $confirmationProblems,
        IAcceptedCallRepository $acceptedCalls,
        IRejectedCallRepository $rejectedCalls,
        IOnSiteLocomotiveRepository $onSiteLocomotives
    ) {
        $this->_calls = $calls;
        $this->_confirmationFinishes = $confirmationFinishes;
        $this->_confirmationProblems = $confirmationProblems;
        $this->_acceptedCalls = $acceptedCalls;
        $this->_rejectedCalls = $rejectedCalls;
        $this->_onSiteLocomotives = $onSiteLocomotives;
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

    public function accept_call(int $call_id)
    {
        $call = $this->_calls->get($call_id);
        if ($call == null) {
            return CallingResult::CallNotFound;
        }

        $this->_acceptedCalls->insert(
            $this->_acceptedCalls->count() + 1,
            $call_id
        );

        return CallingResult::Success;
    }

    public function reject_call(int $call_id, string $reason)
    {
        $call = $this->_calls->get($call_id);
        if ($call == null) {
            return CallingResult::CallNotFound;
        }

        $this->_rejectedCalls->insert(
            $this->_rejectedCalls->count() + 1,
            $call_id,
            $reason
        );

        return CallingResult::Success;
    }
}
