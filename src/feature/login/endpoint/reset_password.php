<?php

namespace lms\feature\login\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../..//../db/lms.php";

use lms\feature\login\reset_password\CentralOfficeResetPasswordHandler;
use lms\feature\login\reset_password\DriverResetPasswordHandler;
use lms\feature\login\reset_password\MaintainerResetPasswordHandler;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;

$step = $_POST['step'];

$driver = new InMemoryDriverRepository([
    new Driver(1, "driver", "email", "password")
]);
$maintainer = new InMemoryMaintainerRepository([
    new Maintainer(1, "maintainer", "email", "password")
]);
$central_office = new InMemoryCentralOfficeRepository([
    new CentralOffice(1, "central_office", "email", "password")
]);


$username = $_POST['username'];

$users = array_merge($driver->getAll(), $maintainer->getAll(), $central_office->getAll());
$target_user = array_filter($users, function (Driver|Maintainer|CentralOffice $user) use ($username) {
    return $user->name == $username;
})[1];

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

    switch (get_class($target_user)) {
        case "lms\\feature\\signup\\entities\\Driver":
            $handler = new DriverResetPasswordHandler($driver);
            $result = $handler->handle($username, $new_password);
            break;

        case "lms\\feature\\signup\\entities\\Maintainer":
            $handler = new MaintainerResetPasswordHandler($maintainer);
            $result = $handler->handle($username, $new_password);

            var_dump($result);
            echo "\n";
            var_dump($maintainer->getAll());

            break;

        case "lms\\feature\\signup\\entities\\CentralOffice":
            $handler = new CentralOfficeResetPasswordHandler($central_office);
            $result = $handler->handle($username, $new_password);
            break;
    }
}
