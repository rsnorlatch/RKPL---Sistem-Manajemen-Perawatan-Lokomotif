<?php

namespace lms\feature\setting\endpoint;

use lms\feature\setting\ThemeDispatcher;
use lms\feature\setting\persistence\MySqlUserPreferenceRepository;
use lms\feature\signup\persistence\MySqlDriverRepository;
use lms\feature\signup\persistence\MySqlMaintainerRepository;
use lms\feature\signup\persistence\MySqlCentralOfficeRepository;
use lms\feature\setting\persistence\RolePreference;

use Exception;

require_once __DIR__ . "/../../../../vendor/autoload.php";
require_once __DIR__ . "/../../../db/lms.php";

session_start();

$theme = $_POST["theme"];

// ── FIX: gunakan isset() konsisten untuk semua role ──
$preferences = isset($_SESSION["user_is_driver"]) ? new MySqlUserPreferenceRepository($db, RolePreference::Driver)
    : (isset($_SESSION["user_is_maintainer"]) ? new MySqlUserPreferenceRepository($db, RolePreference::Maintainer)
        : new MySqlUserPreferenceRepository($db, RolePreference::CentralOffice));

$users = isset($_SESSION["user_is_driver"]) ? new MySqlDriverRepository($db)
    : (isset($_SESSION["user_is_maintainer"]) ? new MySqlMaintainerRepository($db)
        : new MySqlCentralOfficeRepository($db));

$dispatcher = new ThemeDispatcher($preferences, $users);

if ($theme == "day")        $dispatcher->switch_to_light_mode($_SESSION["user_id"]);
else if ($theme == "night") $dispatcher->switch_to_dark_mode($_SESSION["user_id"]);
else throw new Exception("invalid theme");

// Simpan ke session agar halaman lain bisa langsung pakai
$_SESSION["theme"] = $theme;

header("Location: ../../../../front-end/pengaturan_tampilan.php?status=saved");