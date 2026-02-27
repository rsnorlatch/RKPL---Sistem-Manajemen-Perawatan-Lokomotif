<?php
namespace lms\feature\login\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";

use lms\feature\login\LoginHandler;
use lms\feature\login\LoginResult;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;

$username = $_GET['username'];
$password = $_GET['password'];

$driver = new InMemoryDriverRepository([]);
$driver->insert(1, "user1", "user1@gmail.com", "pass");

$maintainer = new InMemoryMaintainerRepository([]);
$central_office = new InMemoryCentralOfficeRepository([]);

$handler = new LoginHandler($driver, $maintainer, $central_office);

$result = $handler->handle($username, $password);

switch ($result) {
    case LoginResult::Success:
        echo "successfully logged in";
        break;

    case LoginResult::UserNotFound:
        echo "username not found";
        break;
    case LoginResult::UsernameOrPasswordIncorrect:
        echo "password incorrect";
        break;
}