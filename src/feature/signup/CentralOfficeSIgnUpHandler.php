<?php

namespace lms\feature\signup;

require_once __DIR__."../../../../vendor/autoload.php";

use lms\feature\signup\entities\ICentralOfficeRepository as ICentralOfficeRepository;

class CentralOfficeSIgnUpHandler
{
    private ICentralOfficeRepository $_central_office;

    function __construct(ICentralOfficeRepository $_central_office)
    {
        $this->_central_office = $_central_office;
    }

    function handle(string $username, string $email, string $password) {
        $new_id = $this->_central_office->count() + 1;

        $this->_central_office->insert($new_id, $username, $email, $password);
    }
}