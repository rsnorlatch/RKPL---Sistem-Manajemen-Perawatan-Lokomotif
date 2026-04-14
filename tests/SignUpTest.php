<?php

require_once __DIR__ . "/../vendor/autoload.php";

use lms\feature\signup\CentralOfficeSIgnUpHandler;
use PHPUnit\Framework\TestCase;
use lms\feature\signup\DriverSignUpHandler;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\MaintainerSignUpHandler;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;

final class SignUpTest extends TestCase
{
  public function testDriverShouldBeAbleToCreateAnAccount()
  {
    $drivers = new InMemoryDriverRepository([]);
    $handler = new DriverSignUpHandler($drivers);

    $handler->handle("username", "email", "password");

    $this->assertTrue([new Driver(1, "username", "email", "password")] == $drivers->getAll());
  }

  public function testMaintainerShouldBeAbleToCreateAnAccount()
  {
    $maintainer = new InMemoryMaintainerRepository([]);
    $handler = new MaintainerSignUpHandler($maintainer);

    $handler->handle("username", "email", "password");

    $this->assertTrue([new Maintainer(1, "username", "email", "password")] == $maintainer->getAll());
  }

  public function testCentralOfficeShouldBeAbleToCreateAccount()
  {
    $central_office = new InMemoryCentralOfficeRepository([]);
    $handler = new CentralOfficeSIgnUpHandler($central_office);

    $handler->handle("username", "email", "password");

    $this->assertTrue([new CentralOffice(1, "username", "email", "password")] == $central_office->getAll());
  }
}
