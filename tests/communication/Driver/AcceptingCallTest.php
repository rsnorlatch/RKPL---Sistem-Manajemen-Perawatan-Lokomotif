<?php

use PHPUnit\Framework\TestCase;
use lms\feature\communication\CallingResult;
use lms\feature\communication\DriverCallingControllerBuilder;
use lms\feature\communication\entities\Call;

final class AcceptingCallTest extends TestCase
{
    public function testDriverShouldBeAbleToAcceptCalls()
    {
        $builder = new DriverCallingControllerBuilder();
        $controller = $builder
            ->populate_call([new Call(1, 1, new DateTime())])
            ->build_fake();

        $result = $controller->accept_call(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testDriverShouldNotBeAbleToAcceptCallThatDoesNotExists()
    {
        $builder = new DriverCallingControllerBuilder();
        $controller = $builder->build_fake();

        $result = $controller->accept_call(1);

        $this->assertEquals(CallingResult::CallNotFound, $result);
    }
}
