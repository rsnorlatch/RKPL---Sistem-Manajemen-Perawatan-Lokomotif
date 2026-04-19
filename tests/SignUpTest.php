<?php

require_once __DIR__ . "/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;
use lms\feature\signup\SignUpHandler;

final class SignUpTest extends TestCase
{
    public function testDriverShouldBeAbleToCreateAnAccount()
    {
        $drivers = new InMemoryDriverRepository([]);
        $handler = new SignUpHandler($drivers);

        $handler->handle("username", "email", "password");

        $this->assertTrue([new Driver(1, "username", "email", "password")] == $drivers->getAll());
    }

    public function testMaintainerShouldBeAbleToCreateAnAccount()
    {
        $maintainer = new InMemoryMaintainerRepository([]);
        $handler = new SignUpHandler($maintainer);

        $handler->handle("username", "email", "password");

        $this->assertTrue([new Maintainer(1, "username", "email", "password")] == $maintainer->getAll());
    }

    public function testCentralOfficeShouldBeAbleToCreateAccount()
    {
        $central_office = new InMemoryCentralOfficeRepository([]);
        $handler = new SignUpHandler($central_office);

        $handler->handle("username", "email", "password");

        $this->assertTrue([new CentralOffice(1, "username", "email", "password")] == $central_office->getAll());
    }
}
