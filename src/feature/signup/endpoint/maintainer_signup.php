<?php

namespace lms\feature\signup\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../../db/lms.php";

use lms\feature\signup\persistence\MySqlMaintainerRepository;
use lms\feature\signup\SignUpHandler;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$maintainer = new MySqlMaintainerRepository($db);
$sign_in_handler = new SignUpHandler($maintainer);

$sign_in_handler->handle($username, $email, $password);
header("Location: ../../../../front-end/login.php");

