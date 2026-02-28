<?php
namespace lms\feature\signup;

use lms\feature\signup\entities\IMaintainerRepository;

class MaintainerSignUpHandler
{
    private IMaintainerRepository $_maintainer;

    function __construct(IMaintainerRepository $_maintainer)
    {
        $this->_maintainer = $_maintainer;
    }

    function handle(string $username, string $email, string $password)
    {
        $new_id = $this->_maintainer->count() + 1;
        $this->_maintainer->insert($new_id, $username, $email, $password);
    }
}





