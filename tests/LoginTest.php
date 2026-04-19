<?php

use lms\feature\login\LoginHandler;
use lms\feature\login\LoginResult;
use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase
{
    public function testEveryTypeOfUser_ShouldBeAbleToLogin()
    {
        $handler = LoginHandler::create_inmemory()
            ->with_driver(1, "driver", "driver@gmail.com", "pass")
            ->with_maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
            ->with_central_Office(1, "central_office", "centraloffice@gmail.com", "pass")
            ->build();

        $driver_result = $handler->handle("driver", "pass");
        $maintainer_result = $handler->handle("maintainer", "pass");
        $central_office_result = $handler->handle("central_office", "pass");

        $this->assertEquals(LoginResult::DriverLoginSuccess, $driver_result);
        $this->assertEquals(LoginResult::MaintainerLoginSuccess, $maintainer_result);
        $this->assertEquals(LoginResult::CentralOfficeLoginSuccess, $central_office_result);
    }

    public function testLoginShouldFail_IfUserDoesNotExists()
    {
        $handler = LoginHandler::create_inmemory()
            ->with_driver(1, "driver", "driver@gmail.com", "pass")
            ->with_maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
            ->with_central_Office(1, "central_office", "centraloffice@gmail.com", "pass")
            ->build();

        $result = $handler->handle("notdriver", "pass");

        $this->assertEquals(LoginResult::UsernameOrPasswordIncorrect, $result);
    }

    public function testLoginShouldFail_IfPasswordIsIncorrect()
    {

        $handler = LoginHandler::create_inmemory()
            ->with_driver(1, "driver", "driver@gmail.com", "pass")
            ->with_maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
            ->with_central_Office(1, "central_office", "centraloffice@gmail.com", "pass")
            ->build();

        $result = $handler->handle("driver", "notpass");

        $this->assertEquals(LoginResult::UsernameOrPasswordIncorrect, $result);
    }

    public function testUserIdShouldBeOnSession_AfterLogin()
    {
        $handler = LoginHandler::create_inmemory()
            ->with_driver(1, "driver", "driver@gmail.com", "pass")
            ->with_maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
            ->with_central_Office(1, "central_office", "centraloffice@gmail.com", "pass")
            ->build();

        $handler->handle("driver", "pass");

        $this->assertEquals(1, $_SESSION['user_id']);
        session_destroy();
    }

    public function testUserShouldBeDefinedOnSession_AfterLogin()
    {
        $handler = LoginHandler::create_inmemory()
            ->with_driver(1, "driver", "driver@gmail.com", "pass")
            ->with_maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
            ->with_central_Office(1, "central_office", "centraloffice@gmail.com", "pass")
            ->build();

        $handler->handle("driver", "pass");

        $this->assertEquals("driver", $_SESSION["user"]);
        session_destroy();
    }

    public function testIsLoggedIn_ShouldBeTrue_AfterLogin()
    {
        $handler = LoginHandler::create_inmemory()
            ->with_driver(1, "driver", "driver@gmail.com", "pass")
            ->with_maintainer(1, "maintainer", "maintainer@gmail.com", "pass")
            ->with_central_Office(1, "central_office", "centraloffice@gmail.com", "pass")
            ->build();

        $handler->handle("driver", "pass");

        $this->assertTrue($_SESSION["is_logged_in"]);
        session_destroy();
    }
}
