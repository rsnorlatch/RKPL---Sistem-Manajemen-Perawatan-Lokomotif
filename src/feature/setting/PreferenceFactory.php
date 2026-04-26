<?php

namespace lms\feature\communication;

use lms\feature\setting\GetCurrentLanguageHandler;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;

use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\setting\persistence\RolePreference;
use lms\feature\setting\ThemeQuery;
use mysqli;

require_once __DIR__ . "/../../../vendor/autoload.php";

class PreferenceFactory
{
    public static function CreateThemeQuery(mysqli $db)
    {
        if (!empty($_SESSION['user_is_driver']))         $role = 'driver';
        elseif (!empty($_SESSION['user_is_maintainer']))  $role = 'maintainer';
        else                                              $role = 'central_office';

        $preferences = $role == "driver" ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
            : ($role == "maintainer" ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
                : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

        $users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
            : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
                : new MySqlCentralOfficeRepository($db));

        $theme_query = new ThemeQuery($preferences, $users);

        return $theme_query;
    }

    public static function CreateLanguageQuery(mysqli $db)
    {
        session_start();
        if (!empty($_SESSION['user_is_driver']))         $role = 'driver';
        elseif (!empty($_SESSION['user_is_maintainer']))  $role = 'maintainer';
        else                                              $role = 'central_office';
        $preferences = $role == "driver" ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
            : ($role == "maintainer" ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
                : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

        $users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
            : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
                : new MySqlCentralOfficeRepository($db));

        $handler =  new GetCurrentLanguageHandler($users, $preferences);
        return $handler;
    }
}
