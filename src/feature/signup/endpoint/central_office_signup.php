<?php
namespace lms\feature\signup\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\signup\CentralOfficeSIgnUpHandler;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;

$username = $_GET['username'];
$email = $_GET['email'];
$password = $_GET['password'];

$maintainer = new InMemoryCentralOfficeRepository([]);
$sign_in_handler = new CentralOfficeSIgnUpHandler($maintainer);

$sign_in_handler->handle($username, $email, $password);
var_dump($maintainer->getAll());
