<?php

namespace lms\feature\login\reset_password;

require_once __DIR__ . "/../../../../vendor/autoload.php";

use Error;
use lms\feature\signup\entities\IMaintainerRepository;
use lms\feature\signup\entities\Maintainer;

class MaintainerResetPasswordHandler
{
    private IMaintainerRepository $_maintainer;

    function __construct(IMaintainerRepository $_maintainer)
    {
        $this->_maintainer = $_maintainer;
    }

    function handle(string $username, string $new_password)
    {
        $drivers = $this->_maintainer->getAll();

        $target_user = array_filter($drivers, function (Maintainer $u) use ($username) {
            return $u->name == $username;
        })[0];

        if ($target_user == null) {
            return PasswordResetResult::UsernameNotFound;
        }

        if ($target_user->id == null) {
            throw new Error("target user does not have the type of Driver");
        }

        $this->_maintainer->update($target_user->id, $target_user->name, $target_user->email, $new_password);

        return PasswordResetResult::Success;
    }
}
