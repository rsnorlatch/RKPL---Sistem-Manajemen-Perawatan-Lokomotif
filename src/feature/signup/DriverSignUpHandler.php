<?php

namespace lms\feature\signup;

require_once __DIR__ . "../../../../vendor/autoload.php";

use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\IDriverRepository as IDriverRepository;
use lms\feature\signup\SignUpResult;

class DriverSignUpHandler
{
    private IDriverRepository $_driver;

    function __construct(IDriverRepository $_driver)
    {
        $this->_driver = $_driver;
    }

    function handle(string $username, string $email, string $password)
    {
        $new_id = $this->_driver->count() + 1;

        $is_taken = count(array_filter($this->_driver->getAll(), function (Driver $d) use ($username) {
            return $d->name == $username;
        })) > 0;

        if ($is_taken)
            return SignUpResult::UsernameTaken;

        $this->_driver->insert($new_id, $username, $email, $password);
    }
}
