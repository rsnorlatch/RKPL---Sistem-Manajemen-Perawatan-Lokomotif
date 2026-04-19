<?php

namespace lms\feature\communication\builder;

use DateTime;
use lms\feature\communication\DriverCallingController;
use lms\feature\communication\entities\AcceptedCall;
use lms\feature\communication\entities\Call;
use lms\feature\communication\entities\ConfirmationFinish;
use lms\feature\communication\entities\ConfirmationProblem;
use lms\feature\communication\entities\RejectedCall;
use lms\feature\communication\persistence\InMemoryAcceptedCallRepository;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;
use lms\feature\communication\persistence\InMemoryRejectedCallRepository;
use lms\feature\locomotive_management\entities\Locomotive;
use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;


class InMemoryDriverCallingControllerBuilder
{
    private $_calls = [];
    private $_confirmationFinishes = [];
    private $_confirmationProblems = [];
    private $_acceptedCalls = [];
    private $_rejectedCalls = [];
    private $_onSiteLocomotives = [];

    public function with_call(int $id, int $driver_id, DateTime $timestamp)
    {
        array_push($this->_calls, new Call($id, $driver_id, $timestamp));

        return $this;
    }
    public function with_confirmation_finishes(int $id, int $driver_id, int $call_id, DateTime $timestamp)
    {
        array_push($this->_confirmationFinishes, new ConfirmationFinish($id, $driver_id, $call_id, $timestamp));

        return $this;
    }
    public function with_confirmation_problems(int $id, int $driver_id, int $call_id, DateTime $timestamp, string $problem)
    {
        array_push($this->_confirmationProblems, new ConfirmationProblem($id, $driver_id, $call_id, $timestamp, $problem));

        return $this;
    }
    public function with_accepted_calls(int $id, int $call_id)
    {
        array_push($this->_acceptedCalls, new AcceptedCall($id, $call_id));

        return $this;
    }
    public function with_rejected_calls(int $id, int $call_id, string $reason)
    {
        array_push($this->_rejectedCalls, new RejectedCall($id, $call_id, $reason));

        return $this;
    }
    public function with_on_site_locomotives(int $id, int $driver_id, string $model)
    {
        array_push($this->_onSiteLocomotives, new Locomotive($id, $driver_id, $model));

        return $this;
    }

    public function build()
    {
        return new DriverCallingController(
            new InMemoryCallRepository($this->_calls),
            new InMemoryConfirmationFinishRepository($this->_confirmationFinishes),
            new InMemoryConfirmationProblemRepository($this->_confirmationProblems),
            new InMemoryAcceptedCallRepository($this->_acceptedCalls),
            new InMemoryRejectedCallRepository($this->_rejectedCalls),
            new InMemoryOnSiteLocomotiveRepository($this->_onSiteLocomotives)
        );
    }
}
