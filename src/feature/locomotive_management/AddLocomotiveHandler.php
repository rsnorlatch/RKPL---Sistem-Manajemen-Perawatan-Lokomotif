<?php
namespace lms\feature\locomotive_management;

require_once __DIR__ . "../../../../vendor/autoload.php";

use lms\feature\locomotive_management\entities\ILocomotiveRepository;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\IDriverRepository;

class AddLocomotiveHandler
{
    private ILocomotiveRepository $_locomotive;
    private IDriverRepository $_driver;

    function __construct(ILocomotiveRepository $_locomotive, IDriverRepository $_driver) {
        $this->_locomotive = $_locomotive;
        $this->_driver = $_driver;
    }

    private function driver_exists(int $driver_id)
    {
        $drivers = $this->_driver->getAll();

        return count(array_filter($drivers, function (Driver $d) use ($driver_id) { 
            return $d->id == $driver_id;
        })) > 0;
    }

    function handle(int $driver_id, string $model) {
        $vacant_id = $this->_locomotive->count() + 1;

        if (!$this->driver_exists($driver_id)) {
            echo "unknown driver";
            return;
        }

        $this->_locomotive->insert($vacant_id, $driver_id, $model);
    }
}