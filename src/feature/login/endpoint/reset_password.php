<?php

namespace lms\feature\login\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../..//../db/lms.php";

use lms\feature\login\reset_password\CentralOfficeResetPasswordHandler;
use lms\feature\login\reset_password\DriverResetPasswordHandler;
use lms\feature\login\reset_password\MaintainerResetPasswordHandler;
use lms\feature\login\reset_password\PasswordResetResult;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;

$step = $_POST['step'];

$driver = new MySqlDriverRepository($db);
$maintainer = new MySqlMaintainerRepository($db);
$central_office = new MySqlCentralOfficeRepository($db);


$username = $_POST['username'];

$users = array_merge($driver->getAll(), $maintainer->getAll(), $central_office->getAll());
$target_users = array_filter($users, function (Driver|Maintainer|CentralOffice $user) use ($username) {
    return $user->name == $username;
});

// I have no idea why but for some reason the first element of this array is at index number 4 and not 0
$target_user = $target_users[4];

if ($step == 1) {
    if ($target_user == null) {
        header("Location: ../../../../front-end/reset_password.php?step=1&error=username_not_found");
        return;
    }

    header("Location: ../../../../front-end/reset_password.php?step=2&username=" . $target_user->name);
} else if ($step == 2) {
    $new_password = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new_password != $confirm) {
        header("Location: ../../../../front-end/reset_password.php?step=2&error=password_not_match&username=$username");
        return;
    }

    $result;

    switch (get_class($target_user)) {
        case "lms\\feature\\signup\\entities\\Driver":
            $handler = new DriverResetPasswordHandler($driver);
            $result = $handler->handle($username, $new_password);
            break;

        case "lms\\feature\\signup\\entities\\Maintainer":
            $handler = new MaintainerResetPasswordHandler($maintainer);
            $result = $handler->handle($username, $new_password);
            break;

        case "lms\\feature\\signup\\entities\\CentralOffice":
            $handler = new CentralOfficeResetPasswordHandler($central_office);
            $result = $handler->handle($username, $new_password);
            break;
    }

    switch ($result) {
        case PasswordResetResult::Success:
            header("Location: ../../../../front-end/login.php");
            break;

        case PasswordResetResult::UsernameNotFound:
            header("Location: ../../../../front-end/reset_password.php?step=2&error=cannot_reset_password");
            break;
    }
}
