<?php

namespace lms\feature\setting\endpoint;

require_once __DIR__ . "/../../../db/lms.php";
require_once __DIR__ . "/../../../../vendor/autoload.php";

use lms\feature\setting\ChangePasswordHandler;
use lms\feature\setting\ChangePasswordResult;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;


$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

session_start();
$user =
    (isset($_SESSION['user_is_driver']) ? new MySqlDriverRepository($db)
        : (isset($_SESSION['user_is_maintainer']) ? new MySqlMaintainerRepository($db)
            : (new MySqlCentralOfficeRepository($db))));

$handler = new ChangePasswordHandler($user);
$result = $handler->handle((int)$_SESSION['user_id'], $old_password, $new_password, $confirm_password);


switch ($result) {
    case ChangePasswordResult::Success:
        header("Location: ../../../../front-end/pengaturan_kredensial.php?status=saved");
        break;

    case ChangePasswordResult::OldPasswordIncorrect:
        header("Location: ../../../../front-end/pengaturan_kredensial.php?status=wrong");
        break;

    case ChangePasswordResult::ConfirmPasswordNotMatch:
        header("Location: ../../../../front-end/pengaturan_kredensial.php?status=mismatch");
        break;

    case ChangePasswordResult::UserNotFound:
        header("Location: ../../../../front-end/pengaturan_kredensial.php?status=error");
        break;
}
