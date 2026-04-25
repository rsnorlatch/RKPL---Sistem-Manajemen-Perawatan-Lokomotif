<?php

/* require_once __DIR__ . "/../vendor/autoload.php"; */

use lms\feature\setting\entities\DriverPreference;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\persistence\InMemoryUserPreferenceRepository;
use lms\feature\setting\ThemeVariant;
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
        $preference = new InMemoryUserPreferenceRepository([]);
        $drivers = new InMemoryDriverRepository([]);
        $handler = new SignUpHandler($drivers, $preference);

        $handler->handle("username", "email", "password");

        $this->assertTrue([new Driver(1, "username", "email", "password")] == $drivers->getAll());
    }

    public function testMaintainerShouldBeAbleToCreateAnAccount()
    {
        $preference = new InMemoryUserPreferenceRepository([]);
        $maintainer = new InMemoryMaintainerRepository([]);
        $handler = new SignUpHandler($maintainer, $preference);

        $handler->handle("username", "email", "password");

        $this->assertTrue([new Maintainer(1, "username", "email", "password")] == $maintainer->getAll());
    }

    public function testCentralOfficeShouldBeAbleToCreateAccount()
    {
        $central_office = new InMemoryCentralOfficeRepository([]);
        $preference = new InMemoryUserPreferenceRepository([]);
        $handler = new SignUpHandler($central_office, $preference);

        $handler->handle("username", "email", "password");

        $this->assertTrue([new CentralOffice(1, "username", "email", "password")] == $central_office->getAll());
    }

    public function testSigninIn_ShouldCreateAPreferenceData()
    {
        $driver = new InMemoryDriverRepository([]);
        $preference = new InMemoryUserPreferenceRepository([]);
        $handler = new SignUpHandler($driver, $preference);
        $driver_id = $driver->count() + 1;
        $handler->handle("username", "email", "password");

        $this->assertEquals([new DriverPreference(1, $driver_id, ThemeVariant::Light, LanguageVariant::Indonesia)], $preference->getAll());
    }
}
