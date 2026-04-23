<?php

use lms\feature\setting\ChangeUsernameHandler;
use lms\feature\setting\ChangeUsernameResult;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use PHPUnit\Framework\TestCase;

final class UserProfileTest extends TestCase
{
    public function testChangingUsernameThatDoesNotExists_ShouldReturnUsernameNotFoundStatus()
    {
        $drivers = new InMemoryDriverRepository([]);
        $drivers->insert(1, "old_username", "email", "password");
        $handler = new ChangeUsernameHandler($drivers);

        $result = $handler->handle("notold_username", "new_username");


        $this->assertEquals(ChangeUsernameResult::UsernameNotFound, $result);
    }

    public function testEnteringExistingUser_ShouldReturnSuccess()
    {
        $drivers = new InMemoryDriverRepository([]);
        $drivers->insert(1, "old_username", "email", "password");
        $handler = new ChangeUsernameHandler($drivers);

        $result = $handler->handle("old_username", "new_username");


        $this->assertEquals(ChangeUsernameResult::Success, $result);
    }

    public function testEnteringExistingUser_ShouldChangeUsername()
    {
        $drivers = new InMemoryDriverRepository([]);
        $drivers->insert(1, "old_username", "email", "password");
        $handler = new ChangeUsernameHandler($drivers);

        $result = $handler->handle("old_username", "new_username");


        $this->assertEquals("new_username", $drivers->get(1)->name);
    }

    public function testOtherUser_ShouldBeAbleToChangeUsername()
    {
        $central_office = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "old_username", "email", "password")
        ]);
        $maintainer = new InMemoryMaintainerRepository([
            new Maintainer(1, "old_username", "email", "password")
        ]);

        $maintianer_handler = new ChangeUsernameHandler($maintainer);
        $central_office_handler = new ChangeUsernameHandler($central_office);

        $central_office_handler->handle("old_username", "new_username");
        $maintianer_handler->handle("old_username", "new_username");


        $this->assertEquals("new_username", $maintainer->get(1)->name);
        $this->assertEquals("new_username", $central_office->get(1)->name);
    }

    public function testChangesInUsername_ShouldReflectToSessionUser()
    {
        $maintainer = new InMemoryMaintainerRepository([]);
        $maintainer->insert(1, "old_username", "email", "pass");
        $handler = new ChangeUsernameHandler($maintainer);

        $handler->handle("old_username", "new_username");

        session_start();
        $this->assertEquals("new_username", $_SESSION['user']);
    }
}
