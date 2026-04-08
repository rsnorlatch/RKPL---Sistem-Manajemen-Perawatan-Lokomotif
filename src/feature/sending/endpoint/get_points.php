<?php

require_once "../../../../vendor/autoload.php";

use lms\feature\sending\entities\Stop;
use lms\feature\sending\persistence\InMemoryStopRepository;

$stops = new InMemoryStopRepository([
    new Stop(1, "Stop 1", -7.801389, 110.364444),
    new Stop(2, "Stop 2", -7.802500, 110.365000),
    new Stop(3, "Stop 3", -7.803200, 110.366100),
    new Stop(4, "Stop 4", -7.804000, 110.367200),
    new Stop(5, "Stop 5", -7.805100, 110.368300)
]);

echo json_encode($stops->getAll());
