<?php

namespace lms\feature\signup\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../../src/db/lms.php";

use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\SignUpHandler;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$central_office = new MySqlCentralOfficeRepository($db);
$sign_in_handler = new SignUpHandler($central_office);

$sign_in_handler->handle($username, $email, $password);
header("Location: ../../../../front-end/login.php");

