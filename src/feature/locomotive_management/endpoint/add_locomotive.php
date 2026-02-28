<?php
namespace lms\feature\locomotive_management\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\locomotive_management\AddLocomotiveHandler;
use lms\feature\locomotive_management\persistence\InMemoryLocomotiveRepository;
use lms\feature\signup\DriverSignUpHandler;
use lms\feature\signup\persistence\InMemoryDriverRepository;

$driver_id = $_GET['driver'];
$model = $_GET['model'];

$driver = new InMemoryDriverRepository([]);
$driver_handler = new DriverSignUpHandler($driver);

$driver_handler->handle("driver1", "driver@driver.com", "password");
$driver_handler->handle("driver2", "driver@driver.com", "password");

var_dump($driver->getAll());

$locomotive = new InMemoryLocomotiveRepository([]);
$handler = new AddLocomotiveHandler($locomotive, $driver);

$handler->handle($driver_id, $model);

var_dump($locomotive);
