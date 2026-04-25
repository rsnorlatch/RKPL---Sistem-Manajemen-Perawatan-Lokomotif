<?php

namespace lms\feature\setting\endpoint;

require_once __DIR__ . "/../..//../db/lms.php";
require_once __DIR__ . "/../../../../vendor/autoload.php";

use lms\feature\setting\ChangeLanguagehandler;
use lms\feature\setting\LanguageVariant;
use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\setting\persistence\RolePreference;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;

session_start();

$lang = $_POST["lang"];

$preferences = isset($_SESSION["user_is_driver"]) ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
    : (isset($_SESSION["user_is_maintainer"]) ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
        : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

$users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
    : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
        : new MySqlCentralOfficeRepository($db));


$handler = new ChangeLanguagehandler($preferences, $users);


switch ($lang) {
    case "id":
        $handler->handle($_SESSION["user_id"], LanguageVariant::Indonesia);
        break;

    case "en":
        $handler->handle($_SESSION["user_id"], LanguageVariant::English);
        break;
}

header("Location: ../../../../front-end/pengaturan_bahasa.php?status=saved");
