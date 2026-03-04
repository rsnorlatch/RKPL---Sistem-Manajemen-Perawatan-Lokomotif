<?php
namespace lms\feature\signup\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\signup\MaintainerSignUpHandler;
use lms\feature\signup\persistence\MySqlMaintainerRepository;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$mysqli = new \mysqli("localhost", "root", "", "lms");

$maintainer = new MySqlMaintainerRepository($mysqli);
$sign_in_handler = new MaintainerSignUpHandler($maintainer);

$sign_in_handler->handle($username, $email, $password);
var_dump($maintainer->getAll());
