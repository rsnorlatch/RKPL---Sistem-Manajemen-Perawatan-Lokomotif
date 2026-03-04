<?php
namespace lms\feature\locomotive_management\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

use lms\feature\locomotive_management\AddLocomotiveHandler;
use lms\feature\signup\DriverSignUpHandler;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\locomotive_management\persistence\MySqlLocomotiveRepository;

$driver_id = $_GET['driver'];
$model = $_GET['model'];

$locomotive = new MySqlLocomotiveRepository($db);
$handler = new AddLocomotiveHandler($locomotive, $driver);

$handler->handle($driver_id, $model);

var_dump($locomotive);
