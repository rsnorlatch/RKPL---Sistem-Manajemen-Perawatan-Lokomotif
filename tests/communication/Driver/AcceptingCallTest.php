<?php

use PHPUnit\Framework\TestCase;
use lms\feature\communication\CallingResult;
use lms\feature\communication\DriverCallingController;
use lms\feature\communication\entities\Call;
use lms\feature\communication\persistence\InMemoryAcceptedCallRepository;
use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;
use lms\feature\communication\persistence\InMemoryRejectedCallRepository;
use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;

final class AcceptingCallTest extends TestCase
{
    public function testDriverShouldBeAbleToAcceptCalls()
    {
        $calls = new InMemoryCallRepository([
            new Call(1, 1, new DateTime())
        ]);
        $confirmation_finishes = new InMemoryConfirmationFinishRepository([]);
        $confirmation_problems = new InMemoryConfirmationProblemRepository([]);
        $accepted_calls = new InMemoryAcceptedCallRepository([]);
        $rejected_calls = new InMemoryRejectedCallRepository([]);
        $onsitelocomotives = new InMemoryOnSiteLocomotiveRepository([]);

        $handler = new DriverCallingController(
            $calls,
            $confirmation_finishes,
            $confirmation_problems,
            $accepted_calls,
            $rejected_calls,
            $onsitelocomotives
        );
        $result = $handler->accept_call(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testDriverShouldNotBeAbleToAcceptCallThatDoesNotExists()
    {
        $calls = new InMemoryCallRepository([]);
        $confirmation_finishes = new InMemoryConfirmationFinishRepository([]);
        $confirmation_problems = new InMemoryConfirmationProblemRepository([]);
        $accepted_calls = new InMemoryAcceptedCallRepository([]);
        $rejected_calls = new InMemoryRejectedCallRepository([]);
        $onsitelocomotives = new InMemoryOnSiteLocomotiveRepository([]);

        $handler = new DriverCallingController(
            $calls,
            $confirmation_finishes,
            $confirmation_problems,
            $accepted_calls,
            $rejected_calls,
            $onsitelocomotives
        );
        $result = $handler->accept_call(1);

        $this->assertEquals(CallingResult::CallNotFound, $result);
    }
}
