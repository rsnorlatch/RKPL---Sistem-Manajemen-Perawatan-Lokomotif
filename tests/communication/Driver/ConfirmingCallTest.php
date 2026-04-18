<?php

use lms\feature\communication\CallingResult;
use lms\feature\communication\entities\AcceptedCall;
use lms\feature\communication\entities\Call;
use PHPUnit\Framework\TestCase;

use lms\feature\communication\DriverCallingControllerBuilder;

final class ConfirmingCallTest extends TestCase
{
    public function testDriverShouldBeAbleToConfirmCall()
    {
        $builder = new DriverCallingControllerBuilder();
        $controller = $builder
            ->populate_call([new Call(1, 1, new DateTime())])
            ->populate_accepted_calls([new AcceptedCall(1, 1)])
            ->build_fake();

        $result = $controller->confirm_finish(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testCallShouldBeDeletedAfterConfirming()
    {
        $builder = new DriverCallingControllerBuilder();
        $controller = $builder
            ->populate_accepted_calls([new AcceptedCall(1, 1)])
            ->populate_call([new Call(1, 1, new DateTime())])
            ->build_fake();

        $controller->confirm_finish(1);

        $this->assertEquals([], $controller->_calls->getAll());
    }

    public function testAcceptedCallShouldBeDeletedAfterConfirmFinish()
    {
        $builder = new DriverCallingControllerBuilder();
        $controller = $builder
            ->populate_call([new Call(1, 1, new DateTime())])
            ->populate_accepted_calls([new AcceptedCall(1, 1)])
            ->build_fake();

        $controller->confirm_finish(1);

        $this->assertEquals([], $controller->_acceptedCalls->getAll());
    }

    // TODO: implement a new behavior that adds locomotive belonged to a particular driver to OnSiteLocomotive storage
    public function testOnSiteLocomotiveShouldNotBeEmptyAfterConfirmingFinish()
    {
        $this->markTestSkipped();

        $builder = new DriverCallingControllerBuilder();
        $controller = $builder
            ->populate_call([new Call(1, 1, new DateTime())])
            ->populate_accepted_calls([new AcceptedCall(1, 1)])
            ->build_fake();

        $controller->confirm_finish(1);

        $this->assertNotEmpty($controller->_onSiteLocomotives->getAll());
    }
}
