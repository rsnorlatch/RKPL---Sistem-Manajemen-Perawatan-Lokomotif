<?php

namespace lms\feature\signup\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../../../src/db/lms.php";

use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\setting\persistence\RolePreference;
use lms\feature\signup\persistence\MySqlDriverRepository as MySqlDriverRepository;
use lms\feature\signup\SignUpHandler;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$driver = new MySqlDriverRepository($db);
$preference = new MySqlUserPreferenceRepository($db, RolePreference::Driver);
$sign_in_handler = new SignUpHandler($driver, $preference);

$sign_in_handler->handle($username, $email, $password);
header("Location: ../../../../front-end/login.php");
