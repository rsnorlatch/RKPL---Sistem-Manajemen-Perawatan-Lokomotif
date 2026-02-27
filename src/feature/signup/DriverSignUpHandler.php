<?php

namespace lms\feature\signup;

require_once __DIR__."../../../../vendor/autoload.php";

use lms\feature\signup\entities\IDriverRepository as IDriverRepository;

class DriverSignUpHandler
{
    private IDriverRepository $_driver;

    function __construct(IDriverRepository $_driver)
    {
        $this->_driver = $_driver;
    }

    function handle(string $username, string $email, string $password) {
        $new_id = $this->_driver->count() + 1;

        $this->_driver->insert($new_id, $username, $email, $password);
    }
}