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

session_start();

switch ($result) {
    case LoginResult::DriverLoginSuccess:
        header("Location: ../../../../front-end/dashboard_masinis.php");
        break;
    case LoginResult::MaintainerLoginSuccess:
        header("Location: ../../../../front-end/dashboard_timbalaiyasa.php");
        break;
    case LoginResult::CentralOfficeLoginSuccess:
        header("Location: ../../../../front-end/dashboard_kantorpusat.php");
        break;
    case LoginResult::UsernameOrPasswordIncorrect:
        header("Location: ../../../../front-end/login.php?status=incorrect_credential");
        break;
    case LoginResult::UserNotFound:
        header("Location: ../../../../front-end/login.php?status=user_not_found");
        break;
}
