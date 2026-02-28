<?php
namespace lms\feature\login;

require_once __DIR__."../../../../vendor/autoload.php";

use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\ICentralOfficeRepository;
use lms\feature\signup\entities\IDriverRepository;
use lms\feature\signup\entities\IMaintainerRepository;

enum LoginResult
{
   case Success;
   case UsernameOrPasswordIncorrect;
   case UserNotFound; 
}

class LoginHandler
{
    private IDriverRepository $_driver;
    private IMaintainerRepository $_maintainer;
    private ICentralOfficeRepository $_central_office;

    function __construct(IDriverRepository $_driver, IMaintainerRepository $_maintainer, ICentralOfficeRepository $_central_office) {
        $this->_driver = $_driver;
        $this->_maintainer = $_maintainer;
        $this->_central_office = $_central_office;
    }

    function handle(string $username, string $password): LoginResult {
        $users = array_merge($this->_driver->getAll(), $this->_maintainer->getAll(), $this->_central_office->getAll());

        $target_user = array_filter($users, function (Driver $u) use ($username, $password) { 
            return $u->name == $username && $u->password == $password; 
        });

        if ($target_user == null) 
            return LoginResult::UsernameOrPasswordIncorrect;

        session_start();
        $_SESSION['user'] = $username;

        return LoginResult::Success;
    }
}