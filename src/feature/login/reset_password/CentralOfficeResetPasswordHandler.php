<?php

namespace lms\feature\login\reset_password;

require_once __DIR__ . "/../../../../vendor/autoload.php";

use Error;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\ICentralOfficeRepository;

class CentralOfficeResetPasswordHandler
{
    private ICentralOfficeRepository $_central_office;

    function __construct(ICentralOfficeRepository $_central_office)
    {
        $this->_central_office = $_central_office;
    }

    function handle(string $username, string $new_password)
    {
        $drivers = $this->_central_office->getAll();

        $target_user = array_filter($drivers, function (CentralOffice $u) use ($username) {
            return $u->name == $username;
        })[0];

        if ($target_user == null) {
            return PasswordResetResult::UsernameNotFound;
        }

        if ($target_user->id == null) {
            throw new Error("target user does not have the type of Driver");
        }

        $this->_central_office->update($target_user->id, $target_user->name, $target_user->email, $new_password);

        return PasswordResetResult::Success;
    }
}
