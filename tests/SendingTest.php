<?php

use lms\feature\sending\SendLocomotiveHandler;
use lms\feature\sending\SendResult;
use PHPUnit\Framework\TestCase;

final class SendingTest extends TestCase
{
    public function testMaintainerShouldBeAbleToSendLocomotive()
    {
        $handler = SendLocomotiveHandler::create_inmemory()
            ->with_onsite_locomotive(1, 1, "Model")
            ->with_stop(1, "stop1", 1, 1)
            ->build();

        $result = $handler->handle(1, 1);

        $this->assertEquals(SendResult::Success, $result);
    }
}
