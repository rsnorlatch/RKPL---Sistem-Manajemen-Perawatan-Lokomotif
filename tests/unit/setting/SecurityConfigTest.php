<?php

use lms\feature\setting\ChangePasswordHandler;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;
use lms\feature\setting\ChangePasswordResult;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use PHPUnit\Framework\TestCase;

final class SecurityConfigTest extends TestCase
{
    public function testWhenUserNotFound_ItShouldGiveUserNotFoundStatus()
    {
        $user = new InMemoryMaintainerRepository([]);
        $handler = new ChangePasswordHandler($user);

        $result = $handler->handle(1, "old_password", "new_pass", "new_pass");

        $this->assertEquals(ChangePasswordResult::UserNotFound, $result);
    }

    public function testWhenPasswordConfirmDidNotMatch_ItShouldGiveConfirmNotMatchStatus()
    {
        $user = new InMemoryDriverRepository([]);
        $user->insert(1, "username", "email", "old_pass");
        $handler = new ChangePasswordHandler($user);

        $result = $handler->handle(1, "old_pass", "new_pass", "confirm_pass");

        $this->assertEquals(ChangePasswordResult::ConfirmPasswordNotMatch, $result);
    }

    public function testWhenPasswordConfirmMatch_ItShouldChangePassword()
    {
        $user = new InMemoryCentralOfficeRepository([]);
        $user->insert(1, "username", "email", "old_pass");
        $handler = new ChangePasswordHandler($user);

        $handler->handle(1, "old_pass", "new_pass", "new_pass");

        $this->assertEquals("new_pass", $user->get(1)->password);
    }

    public function testWhenPasswordConfirmMatch_ItShouldGiveSuccessStatus()
    {
        $user = new InMemoryMaintainerRepository([]);
        $user->insert(1, "username", "email", "old_pass");
        $handler = new ChangePasswordHandler($user);

        $result = $handler->handle(1, "old_pass", "new_pass", "new_pass");

        $this->assertEquals(ChangePasswordResult::Success, $result);
    }

    public function testIfOldPassDoNotMatch_ItShouldNotChangePassword()
    {
        $user = new InMemoryMaintainerRepository([]);
        $user->insert(1, "username", "email", "old_pass");
        $handler = new ChangePasswordHandler($user);

        $handler->handle(1, "old_password", "new_pass", "new_pass");

        $this->assertEquals("old_pass", $user->get(1)->password);
    }

    public function testIfOldPassDoNotMatch_ItShouldGiveIncorrectCredentialStatus()
    {
        $user = new InMemoryMaintainerRepository([]);
        $user->insert(1, "username", "email", "old_pass");
        $handler = new ChangePasswordHandler($user);

        $result = $handler->handle(1, "old_password", "new_pass", "new_pass");

        $this->assertEquals(ChangePasswordResult::OldPasswordIncorrect, $result);
    }
}
