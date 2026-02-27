<?php
namespace lms\feature\signup\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\signup\DriverSignUpHandler as DriverSignUpHandler;
use lms\feature\signup\persistence\InMemoryDriverRepository as InMemoryDriverRepository;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$driver = new InMemoryDriverRepository([]);
$sign_in_handler = new DriverSignUpHandler($driver);

$sign_in_handler->handle($username, $email, $password);
var_dump($driver->getAll());
