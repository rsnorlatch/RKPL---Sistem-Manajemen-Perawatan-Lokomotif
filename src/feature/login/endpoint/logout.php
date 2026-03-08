<?php

namespace lms\feature\login\endpoint;

require_once __DIR__ . "/../../../../vendor/autoload.php";

use lms\feature\login\LogoutHandler;

$handler = new LogoutHandler();

$handler->handle();
