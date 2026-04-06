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

/* $step = $_POST['step']; */
/* $username = $_POST['username']; */
/* $new_passwored = $_POST['password']; */

$step = 1;
$username = "driver";
$new_password = "newpass";

$driver = new InMemoryDriverRepository([
    new Driver(1, "driver", "email", "password")
]);
$maintainer = new InMemoryMaintainerRepository([
    new Maintainer(1, "maintainer", "email", "password")
]);
$central_office = new InMemoryCentralOfficeRepository([
    new CentralOffice(1, "central_office", "email", "password")
]);

if ($step === 1) {
    $users = array_merge($driver->getAll(), $maintainer->getAll(), $central_office->getAll());
    $target_user = array_filter($users, function (Driver|Maintainer|CentralOffice $user) use ($username) {
        return $user->name == $username;
    });
} else if ($step === 2) {
    switch (get_class($target_user)) {
        case "Driver":
            $handler = new DriverResetPasswordHandler($driver);
            $result = $handler->handle("username", "newpass");
            break;

        case "Maintainer":
            $handler = new MaintainerResetPasswordHandler($maintainer);
            $result = $handler->handle($username, $new_password);
            break;

        case "CentralOffice":
            $handler = new CentralOfficeResetPasswordHandler($central_office);
            $result = $handler->handle($username, $new_password);
            break;
    }
}
