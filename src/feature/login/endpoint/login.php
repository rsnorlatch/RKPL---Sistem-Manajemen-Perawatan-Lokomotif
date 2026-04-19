<?php

namespace lms\feature\login\endpoint;

require_once __DIR__ . "../../../../../vendor/autoload.php";
require_once __DIR__ . "../../../../db/lms.php";

use lms\feature\login\LoginHandler;
use lms\feature\login\LoginResult;

$username = $_POST['username'];
$password = $_POST['password'];

$handler = LoginHandler::create_mysql($db);

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
