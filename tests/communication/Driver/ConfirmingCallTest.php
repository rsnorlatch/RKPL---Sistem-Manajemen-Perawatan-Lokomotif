<?php

use lms\feature\communication\CallingResult;
use lms\feature\communication\DriverCallingController;

use PHPUnit\Framework\TestCase;

final class ConfirmingCallTest extends TestCase
{
    public function testDriverShouldBeAbleToConfirmCall()
    {
        $controller = DriverCallingController::create_inmemory()
            ->with_call(1, 1, new DateTime())
            ->with_accepted_calls(1, 1)
            ->build();

        $result = $controller->confirm_finish(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testCallShouldBeDeletedAfterConfirming()
    {
        $controller = DriverCallingController::create_inmemory()
            ->with_accepted_calls(1, 1)
            ->with_call(1, 1, new DateTime())
            ->build();

        $controller->confirm_finish(1);

        $this->assertEquals([], $controller->_calls->getAll());
    }

    public function testAcceptedCallShouldBeDeletedAfterConfirmFinish()
    {
        $controller = DriverCallingController::create_inmemory()
            ->with_call(1, 1, new DateTime())
            ->with_accepted_calls(1, 1)
            ->build();

        $controller->confirm_finish(1);

        $this->assertEquals([], $controller->_acceptedCalls->getAll());
    }

    // TODO: implement a new behavior that adds locomotive belonged to a particular driver to OnSiteLocomotive storage
    public function testOnSiteLocomotiveShouldNotBeEmptyAfterConfirmingFinish()
    {
        $this->markTestSkipped();

        $controller = DriverCallingController::create_inmemory()
            ->with_call(1, 1, new DateTime())
            ->with_accepted_calls(1, 1)
            ->build();

        $controller->confirm_finish(1);

        $this->assertNotEmpty($controller->_onSiteLocomotives->getAll());
    }
}
