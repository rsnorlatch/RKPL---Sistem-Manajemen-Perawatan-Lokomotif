<?php

namespace lms\feature\setting\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../../db/lms.php";

use lms\feature\setting\ChangeUsernameHandler;
use lms\feature\setting\ChangeUsernameResult;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;

session_start();
$name = $_POST['nama'];

$user =
    (isset($_SESSION['user_is_driver']) ? new MySqlDriverRepository($db)
        : (isset($_SESSION['user_is_maintainer']) ? new MySqlMaintainerRepository($db)
            : (new MySqlCentralOfficeRepository($db))));

$handler = new ChangeUsernameHandler($user);
$result = $handler->handle($_SESSION['user'], $name);

switch ($result) {
    case ChangeUsernameResult::UsernameNotFound:
        header("Location: ../../../../front-end/pengaturan_profil.php?status=error");
        break;

    case ChangeUsernameResult::Success:
        header("Location: ../../../../front-end/pengaturan_profil.php?status=saved");
        break;
}
