<?php

require_once "../../../../vendor/autoload.php";
require_once "../../../db/lms.php";

use lms\feature\sending\persistence\MySqlStopRepository;

$stops = new MySqlStopRepository($db);

echo json_encode($stops->getAll());
