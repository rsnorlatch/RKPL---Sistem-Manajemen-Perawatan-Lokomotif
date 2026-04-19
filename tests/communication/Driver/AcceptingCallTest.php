<?php

use PHPUnit\Framework\TestCase;
use lms\feature\communication\CallingResult;
use lms\feature\communication\DriverCallingController;

final class AcceptingCallTest extends TestCase
{
    public function testDriverShouldBeAbleToAcceptCalls()
    {
        $controller = DriverCallingController::create_inmemory()
            ->with_call(1, 1, new DateTime())
            ->build();

        $result = $controller->accept_call(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testDriverShouldNotBeAbleToAcceptCallThatDoesNotExists()
    {
        $controller = DriverCallingController::create_inmemory()->build();

        $result = $controller->accept_call(1);

        $this->assertEquals(CallingResult::CallNotFound, $result);
    }
}
