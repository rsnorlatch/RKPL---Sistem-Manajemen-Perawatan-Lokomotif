<?php

namespace lms\feature\login\reset_password;

require_once __DIR__ . "/../../../../vendor/autoload.php";

use Error;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\IDriverRepository;


class DriverResetPasswordHandler
{
    private IDriverRepository $_driver;

    function __construct(IDriverRepository $_driver)
    {
        $this->_driver = $_driver;
    }

    function handle(string $username, string $new_password)
    {
        $drivers = $this->_driver->getAll();

        $target_user = array_filter($drivers, function (Driver $u) use ($username) {
            return $u->name == $username;
        })[2];

        if ($target_user == null) {
            return PasswordResetResult::UsernameNotFound;
        }

        if ($target_user->id == null) {
            throw new Error("target user does not have the type of Driver");
        }

        $this->_driver->update($target_user->id, $target_user->name, $target_user->email, $new_password);

        return PasswordResetResult::Success;
    }
}
