<?php

use lms\feature\login\LoginHandler;
use lms\feature\login\LoginResult;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;
use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase
{
    public function testEveryTypeOfUser_ShouldBeAbleToLogin()
    {
        $drivers = new InMemoryDriverRepository([
            new Driver(1, "driver", "driver@email.com", "pass")
        ]);
        $maintainers = new InMemoryMaintainerRepository([
            new Maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
        ]);
        $central_offices = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "central_office", "centraloffice@gmail.com", "pass")
        ]);


        $handler = new LoginHandler($drivers, $maintainers, $central_offices);
        $driver_result = $handler->handle("driver", "pass");
        $maintainer_result = $handler->handle("maintainer", "pass");
        $central_office_result = $handler->handle("central_office", "pass");

        $this->assertEquals(LoginResult::DriverLoginSuccess, $driver_result);
        $this->assertEquals(LoginResult::MaintainerLoginSuccess, $maintainer_result);
        $this->assertEquals(LoginResult::CentralOfficeLoginSuccess, $central_office_result);
    }

    public function testLoginShouldFail_IfUserDoesNotExists()
    {
        $drivers = new InMemoryDriverRepository([
            new Driver(1, "driver", "driver@email.com", "pass")
        ]);
        $maintainers = new InMemoryMaintainerRepository([
            new Maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
        ]);
        $central_offices = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "central_office", "centraloffice@gmail.com", "pass")
        ]);


        $handler = new LoginHandler($drivers, $maintainers, $central_offices);

        $result = $handler->handle("notdriver", "pass");

        $this->assertEquals(LoginResult::UsernameOrPasswordIncorrect, $result);
    }

    public function testLoginShouldFail_IfPasswordIsIncorrect()
    {

        $drivers = new InMemoryDriverRepository([
            new Driver(1, "driver", "driver@email.com", "pass")
        ]);
        $maintainers = new InMemoryMaintainerRepository([
            new Maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
        ]);
        $central_offices = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "central_office", "centraloffice@gmail.com", "pass")
        ]);

        $handler = new LoginHandler($drivers, $maintainers, $central_offices);
        $result = $handler->handle("driver", "notpass");

        $this->assertEquals(LoginResult::UsernameOrPasswordIncorrect, $result);
    }

    public function testUserIdShouldBeOnSession_AfterLogin()
    {
        $drivers = new InMemoryDriverRepository([
            new Driver(1, "driver", "driver@email.com", "pass")
        ]);
        $maintainers = new InMemoryMaintainerRepository([
            new Maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
        ]);
        $central_offices = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "central_office", "centraloffice@gmail.com", "pass")
        ]);

        $handler = new LoginHandler($drivers, $maintainers, $central_offices);
        $handler->handle("driver", "pass");

        $this->assertEquals(1, $_SESSION['user_id']);
        session_destroy();
    }

    public function testUserShouldBeDefinedOnSession_AfterLogin()
    {
        $drivers = new InMemoryDriverRepository([
            new Driver(1, "driver", "driver@email.com", "pass")
        ]);
        $maintainers = new InMemoryMaintainerRepository([
            new Maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
        ]);
        $central_offices = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "central_office", "centraloffice@gmail.com", "pass")
        ]);

        $handler = new LoginHandler($drivers, $maintainers, $central_offices);
        $handler->handle("driver", "pass");

        $this->assertEquals("driver", $_SESSION["user"]);
        session_destroy();
    }

    public function testIsLoggedIn_ShouldBeTrue_AfterLogin()
    {
        $drivers = new InMemoryDriverRepository([
            new Driver(1, "driver", "driver@email.com", "pass")
        ]);
        $maintainers = new InMemoryMaintainerRepository([
            new Maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
        ]);
        $central_offices = new InMemoryCentralOfficeRepository([
            new CentralOffice(1, "central_office", "centraloffice@gmail.com", "pass")
        ]);

        $handler = new LoginHandler($drivers, $maintainers, $central_offices);
        $handler->handle("driver", "pass");

        $this->assertTrue($_SESSION["is_logged_in"]);
        session_destroy();
    }
}
