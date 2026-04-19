<?php

namespace lms\feature\login;

use lms\feature\login\LoginHandler;
use lms\feature\signup\entities\CentralOffice;
use lms\feature\signup\entities\Driver;
use lms\feature\signup\entities\Maintainer;
use lms\feature\signup\persistence\InMemoryCentralOfficeRepository;
use lms\feature\signup\persistence\InMemoryDriverRepository;
use lms\feature\signup\persistence\InMemoryMaintainerRepository;

class InMemoryLoginHandlerBuilder
{
    private $_drivers = [];
    private $_maintainers = [];
    private $_central_office = [];

    public function with_driver($id, $name, $email, $password)
    {
        array_push($this->_drivers, new Driver($id, $name, $email, $password));

        return $this;
    }

    public function with_maintainer($id, $name, $email, $password)
    {
        array_push($this->_maintainers, new Maintainer($id, $name, $email, $password));

        return $this;
    }

    public function with_central_Office($id, $name, $email, $password)
    {
        array_push($this->_central_office, new CentralOffice($id, $name, $email, $password));

        return $this;
    }

    public function build()
    {
        return new LoginHandler(
            new InMemoryDriverRepository($this->_drivers),
            new InMemoryMaintainerRepository($this->_maintainers),
            new InMemoryCentralOfficeRepository($this->_central_office)
        );
    }
}
