<?php

namespace lms\feature\signup\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../../src/db/lms.php";

use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\setting\persistence\RolePreference;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\SignUpHandler;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$central_office = new MySqlCentralOfficeRepository($db);
$preference = new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice);
$sign_in_handler = new SignUpHandler($central_office, $preference);

$sign_in_handler->handle($username, $email, $password);
header("Location: ../../../../front-end/login.php");
