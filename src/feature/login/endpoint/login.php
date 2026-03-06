<?php
namespace lms\feature\login\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

use lms\feature\login\LoginHandler;
use lms\feature\login\LoginResult;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;

$username = $_POST['username'];
$password = $_POST['password'];

$driver = new MySqlDriverRepository($db);
$maintainer = new MySqlMaintainerRepository($db);
$central_office = new MySqlCentralOfficeRepository($db);

$handler = new LoginHandler($driver, $maintainer, $central_office);

$result = $handler->handle($username, $password);

switch ($result) {
    case LoginResult::DriverLoginSuccess:
        echo "Driver login successful!";
        break;
    case LoginResult::MaintainerLoginSuccess:
        echo "Maintainer login successful!";
        break;
    case LoginResult::CentralOfficeLoginSuccess:
        echo "Central office login successful!";
        break;
    case LoginResult::UsernameOrPasswordIncorrect:
        echo "Username or password is incorrect.";
        break;
    case LoginResult::UserNotFound:
        echo "User not found.";
        break;
}