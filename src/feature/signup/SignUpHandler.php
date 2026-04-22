<?php

namespace lms\feature\signup;

use lms\feature\signup\entities\IUserRepository;
use lms\feature\signup\entities\User;

class SignUpHandler
{
    public IUserRepository $_users;

    public function __construct(IUserRepository $users)
    {
        $this->_users = $users;
    }

    public function handle($username, $email, $password)
    {
        $new_id = $this->_users->count() + 1;

        $is_taken = count(array_filter($this->_users->getAll(), function (User $d) use ($username, $email) {
            return $d->name == $username || $d->email == $email;
        })) > 0;

        if ($is_taken)
            return SignUpResult::UsernameTaken;

        $this->_users->insert($new_id, $username, $email, $password);
    }
}
