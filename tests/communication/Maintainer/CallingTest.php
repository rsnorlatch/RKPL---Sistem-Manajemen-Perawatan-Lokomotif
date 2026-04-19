<?php

require_once __DIR__ . "/../../../vendor/autoload.php";

use lms\feature\communication\CallingResult;
use lms\feature\communication\MaintainerCallingController;
use PHPUnit\Framework\TestCase;

final class CallingTest extends TestCase
{
    public function testMaintainerShouldBeAbleToCallLocomotive()
    {
        $controller = MaintainerCallingController::create_inmemory()
            ->with_locomotive(1, 1, "Model")
            ->build();

        $result = $controller->call_locomotive(1);

        $this->assertEquals(CallingResult::Success, $result);
    }

    public function testItShouldNotBeAbleToCallLocomotiveThatDoesNotExist()
    {
        $controller = MaintainerCallingController::create_inmemory()->build();

        $result = $controller->call_locomotive(1);

        $this->assertEquals(CallingResult::LocomotiveNotFound, $result);
    }

    public function testACallShouldBeCreatedAfterCalling()
    {
        $controller = MaintainerCallingController::create_inmemory()
            ->with_locomotive(1, 1, "Model")
            ->build();

        $controller->call_locomotive(1);

        $this->assertNotEmpty($controller->_call->getAll());
    }
}
