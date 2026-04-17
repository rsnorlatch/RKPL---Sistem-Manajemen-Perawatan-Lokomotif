<?php

use lms\feature\communication\CallingResult;
use lms\feature\communication\entities\AcceptedCall;
use lms\feature\communication\entities\Call;
use PHPUnit\Framework\TestCase;

use lms\feature\communication\persistence\InMemoryCallRepository;
use lms\feature\communication\persistence\InMemoryConfirmationFinishRepository;
use lms\feature\communication\persistence\InMemoryConfirmationProblemRepository;
use lms\feature\communication\persistence\InMemoryAcceptedCallRepository;
use lms\feature\communication\persistence\InMemoryRejectedCallRepository;
use lms\feature\locomotive_management\persistence\InMemoryOnSiteLocomotiveRepository;
use lms\feature\communication\DriverCallingController;

final class ConfirmingCallTest extends TestCase
{
    public function testDriverShouldBeAbleToConfirmCall()
    {
        $calls = new InMemoryCallRepository([
            new Call(1, 1, new DateTime())
        ]);
        $confirmation_finishes = new InMemoryConfirmationFinishRepository([]);
        $confirmation_problems = new InMemoryConfirmationProblemRepository([]);
        $accepted_calls = new InMemoryAcceptedCallRepository([
            new AcceptedCall(1, 1)
        ]);
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
        $result = $handler->confirm_finish(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testCallShouldBeDeletedAfterConfirming()
    {
        $calls = new InMemoryCallRepository([
            new Call(1, 1, new DateTime())
        ]);
        $confirmation_finishes = new InMemoryConfirmationFinishRepository([]);
        $confirmation_problems = new InMemoryConfirmationProblemRepository([]);
        $accepted_calls = new InMemoryAcceptedCallRepository([
            new AcceptedCall(1, 1)
        ]);
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
        $handler->confirm_finish(1);

        $this->assertEquals([], $calls->getAll());
    }

    public function testAcceptedCallShouldBeDeletedAfterConfirmFinish()
    {
        $calls = new InMemoryCallRepository([
            new Call(1, 1, new DateTime())
        ]);
        $confirmation_finishes = new InMemoryConfirmationFinishRepository([]);
        $confirmation_problems = new InMemoryConfirmationProblemRepository([]);
        $accepted_calls = new InMemoryAcceptedCallRepository([
            new AcceptedCall(1, 1)
        ]);
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
        $handler->confirm_finish(1);

        $this->assertEquals([], $accepted_calls->getAll());
    }

    // TODO: implement a new behavior that adds locomotive belonged to a particular driver to OnSiteLocomotive storage
    public function testOnSiteLocomotiveShouldNotBeEmptyAfterConfirmingFinish()
    {
        $calls = new InMemoryCallRepository([
            new Call(1, 1, new DateTime())
        ]);
        $confirmation_finishes = new InMemoryConfirmationFinishRepository([]);
        $confirmation_problems = new InMemoryConfirmationProblemRepository([]);
        $accepted_calls = new InMemoryAcceptedCallRepository([
            new AcceptedCall(1, 1)
        ]);
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
        $handler->confirm_finish(1);

        $this->assertNotEmpty($onsitelocomotives->getAll());
    }
}
